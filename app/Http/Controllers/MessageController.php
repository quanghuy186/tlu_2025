<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Hiển thị trang chat
     */
    public function index(Request $request)
    {
        // Lấy danh sách người dùng đã có lịch sử trò chuyện với người dùng hiện tại
        $users = $this->getUsersWithChatHistory();
        
        // Kiểm tra xem có người dùng mới được chọn từ danh bạ không
        if ($request->has('new_user_id')) {
            $newUser = User::find($request->new_user_id);
            if ($newUser && !$users->contains('id', $newUser->id)) {
                // Thêm người dùng mới vào đầu danh sách
                $users->prepend($newUser);
            }
        }
        
        return view('chat.index', compact('users'));
    }
    
    /**
     * Lấy danh sách người dùng đã có lịch sử trò chuyện
     */
    private function getUsersWithChatHistory()
    {
        $currentUserId = Auth::id();
        
        // Lấy ID của những người dùng đã từng nhắn tin với người dùng hiện tại
        $userIds = Message::where(function($query) use ($currentUserId) {
                $query->where('sender_user_id', $currentUserId)
                      ->orWhere('recipient_user_id', $currentUserId);
            })
            ->where('is_deleted', false)
            ->select('sender_user_id', 'recipient_user_id')
            ->get()
            ->flatMap(function($message) use ($currentUserId) {
                // Chỉ lấy ID của người còn lại trong cuộc trò chuyện
                return [$message->sender_user_id, $message->recipient_user_id];
            })
            ->unique()
            ->reject(function($userId) use ($currentUserId) {
                // Loại bỏ ID của người dùng hiện tại
                return $userId == $currentUserId;
            });
        
        return User::whereIn('id', $userIds)->get();
    }
    
    /**
     * Hiển thị danh bạ tất cả người dùng để bắt đầu cuộc trò chuyện mới
     */
    public function contacts()
    {
        // Lấy tất cả người dùng trừ người dùng hiện tại
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.contacts', compact('users'));
    }
    
    /**
     * Bắt đầu cuộc trò chuyện với người dùng từ danh bạ
     */
    public function startChat($userId)
    {
        // Kiểm tra người dùng có tồn tại không
        $user = User::findOrFail($userId);
        
        // Chuyển hướng đến trang chat với tham số user_id
        return redirect()->route('chat.index', ['new_user_id' => $userId]);
    }

    public function getMessages(User $user)
    {
        // Lấy tin nhắn giữa người dùng hiện tại và người dùng đã chọn
        $messages = Message::where(function($query) use ($user) {
                $query->where('sender_user_id', Auth::id())
                      ->where('recipient_user_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_user_id', $user->id)
                      ->where('recipient_user_id', Auth::id());
            })
            ->where('is_deleted', false)
            ->orderBy('sent_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required_without:file',
            'file' => 'nullable|file|max:5120', // 5MB max
        ]);

        $message = new Message();
        $message->sender_user_id = Auth::id();
        $message->recipient_user_id = $request->recipient_id;
        $message->content = $request->content ?? '';

        // Xử lý file nếu có
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('chat_files', $fileName, 'public');
            $message->file_url = 'storage/chat_files/' . $fileName;
            $message->message_type = 'file';
        }

        $message->sent_at = now();
        $message->save();

        // Broadcast sự kiện
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function markAsRead(Message $message)
    {
        // Chỉ người nhận mới có thể đánh dấu đã đọc
        if ($message->recipient_user_id == Auth::id()) {
            $message->is_read = true;
            $message->save();
        }
        
        return response()->json(['success' => true]);
    }

    public function deleteMessage(Message $message)
    {
        // Chỉ người gửi hoặc người nhận mới có thể xóa
        if ($message->sender_user_id == Auth::id() || $message->recipient_user_id == Auth::id()) {
            $message->is_deleted = true;
            $message->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 403);
    }
}