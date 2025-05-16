<?php

namespace App\Http\Controllers\Page;

use App\Events\NewMessage;
use App\Events\UserTyping;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function index()
    {
        $contacts = $this->getContacts();
        return view('pages.message', compact('contacts'));
    }

    /**
     * Lấy danh sách liên hệ cho người dùng hiện tại.
     */
    public function getContacts()
    {
        $userId = Auth::id();

        // Lấy danh sách người dùng mà user hiện tại đã trò chuyện
        $contacts = User::whereIn('id', function ($query) use ($userId) {
            $query->select('sender_user_id')
                ->from('messages')
                ->where('recipient_user_id', $userId)
                ->union(
                    Message::select('recipient_user_id')
                        ->where('sender_user_id', $userId)
                );
        })
        ->withCount(['unreadMessages' => function ($query) use ($userId) {
            $query->where('sender_user_id', '!=', $userId)
                  ->where('recipient_user_id', $userId)
                  ->where('is_read', false);
        }])
        ->get();

        foreach ($contacts as $contact) {
            $lastMessage = Message::where(function ($query) use ($userId, $contact) {
                $query->where('sender_user_id', $userId)
                      ->where('recipient_user_id', $contact->id);
            })
            ->orWhere(function ($query) use ($userId, $contact) {
                $query->where('sender_user_id', $contact->id)
                      ->where('recipient_user_id', $userId);
            })
            ->orderBy('sent_at', 'desc')
            ->first();

            $contact->last_message = $lastMessage;
        }

        return $contacts;
    }

    /**
     * Lấy tin nhắn giữa user hiện tại và user được chọn.
     */
    public function getMessages($userId)
    {
        $currentUserId = Auth::id();

        // Đánh dấu tất cả tin nhắn từ user được chọn gửi đến user hiện tại là đã đọc
        Message::where('sender_user_id', $userId)
               ->where('recipient_user_id', $currentUserId)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        // Lấy lịch sử tin nhắn
        $messages = Message::where(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_user_id', $currentUserId)
                  ->where('recipient_user_id', $userId);
        })
        ->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_user_id', $userId)
                  ->where('recipient_user_id', $currentUserId);
        })
        ->with(['sender'])
        ->orderBy('sent_at', 'asc')
        ->get();

        $recipient = User::find($userId);

        return response()->json([
            'messages' => $messages,
            'recipient' => $recipient
        ]);
    }

    /**
     * Gửi tin nhắn mới.
     */
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required_without:file',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fileUrl = null;
        $messageType = 'text';

        // Xử lý file nếu có
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileUrl = $this->fileService->saveFile($file);
            $messageType = $this->fileService->getFileType($file->getMimeType());
        }

        // Tạo tin nhắn mới
        $message = Message::create([
            'sender_user_id' => Auth::id(),
            'recipient_user_id' => $request->recipient_id,
            'message_type' => $messageType,
            'content' => $request->content ?? '',
            'file_url' => $fileUrl,
            'sent_at' => now(),
        ]);

        // Load thông tin người gửi
        $message->load('sender');

        // Broadcast event
        broadcast(new NewMessage($message))->toOthers();

        return response()->json($message);
    }


    /**
     * Đánh dấu tin nhắn là đã đọc.
     */
    public function markAsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message_id' => 'required|exists:messages,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $message = Message::findOrFail($request->message_id);
        
        // Kiểm tra xem người dùng hiện tại có phải là người nhận không
        if ($message->recipient_user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Tìm kiếm người dùng để bắt đầu cuộc trò chuyện mới.
     */
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        
        $users = User::where('id', '!=', Auth::id())
                     ->where(function($q) use ($query) {
                         $q->where('name', 'like', "%{$query}%")
                           ->orWhere('email', 'like', "%{$query}%");
                     })
                     ->limit(10)
                     ->get();
                     
        return response()->json($users);
    }

    /**
 * Gửi trạng thái đang nhập cho người nhận.
 */
    public function sendTypingStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_id' => 'required|exists:users,id',
            'is_typing' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        broadcast(new UserTyping(
            Auth::id(),
            $request->recipient_id,
            $request->is_typing
        ))->toOthers();

        return response()->json(['success' => true]);
    }
}
