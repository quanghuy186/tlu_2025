<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $users = $this->getUsersWithChatHistory();
        
        if ($request->has('new_user_id')) {
            $newUser = User::find($request->new_user_id);
            if ($newUser && !$users->contains('id', $newUser->id)) {
                $users->prepend($newUser);
            }
        }
        
        return view('chat.index', compact('users'));
    }
    
    // private function getUsersWithChatHistory()
    // {
    //     $currentUserId = Auth::id();
        
    //     // Lấy id của những người dùng đã từng nhắn tin với người dùng hiện tại
    //     $userIds = Message::where(function($query) use ($currentUserId) {
    //             $query->where('sender_user_id', $currentUserId)
    //                   ->orWhere('recipient_user_id', $currentUserId);
    //         })
    //         ->where('is_deleted', false)
    //         ->select('sender_user_id', 'recipient_user_id')
    //         ->get()
    //         ->flatMap(function($message) use ($currentUserId) {
    //             // Chỉ lấy ID của người còn lại trong cuộc trò chuyện
    //             return [$message->sender_user_id, $message->recipient_user_id];
    //         })
    //         ->unique()
    //         ->reject(function($userId) use ($currentUserId) {
    //             // Loại bỏ ID của người dùng hiện tại
    //             return $userId == $currentUserId;
    //         });
        
    //     return User::whereIn('id', $userIds)->get();
    // }

    private function getUsersWithChatHistory()
    {
        $currentUserId = Auth::id();
        
        // Lấy tin nhắn chưa bị xóa bởi người dùng hiện tại
        $messages = Message::where(function($query) use ($currentUserId) {
                $query->where('sender_user_id', $currentUserId)
                    ->orWhere('recipient_user_id', $currentUserId);
            })
            ->where('is_deleted', false)
            ->get();
        
        // Lọc ra những tin nhắn chưa bị người dùng hiện tại xóa
        $filteredMessages = $messages->reject(function($message) use ($currentUserId) {
            return $message->isDeletedBy($currentUserId);
        });
        
        // Lấy id của những người dùng đã từng nhắn tin với người dùng hiện tại và tin nhắn chưa bị xóa
        $userIds = $filteredMessages->flatMap(function($message) use ($currentUserId) {
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
    public function startChat($userId)
    {
        $user = User::findOrFail($userId);
        
        return redirect()->route('chat.index', ['new_user_id' => $userId]);
    }

    // public function getMessages(User $user)
    // {
    //     $messages = Message::where(function($query) use ($user) {
    //             $query->where('sender_user_id', Auth::id())
    //                   ->where('recipient_user_id', $user->id);
    //         })
    //         ->orWhere(function($query) use ($user) {
    //             $query->where('sender_user_id', $user->id)
    //                   ->where('recipient_user_id', Auth::id());
    //         })
    //         ->where('is_deleted', false)
    //         ->orderBy('sent_at', 'asc')
    //         ->get();

    //     return response()->json(['messages' => $messages]);
    // }

    public function getMessages(User $user)
    {
        $currentUserId = Auth::id();
        
        // Lấy tin nhắn giữa người dùng hiện tại và người dùng đã chọn
        $messages = Message::where(function($query) use ($user, $currentUserId) {
                $query->where('sender_user_id', $currentUserId)
                    ->where('recipient_user_id', $user->id);
            })
            ->orWhere(function($query) use ($user, $currentUserId) {
                $query->where('sender_user_id', $user->id)
                    ->where('recipient_user_id', $currentUserId);
            })
            ->where('is_deleted', false) // Không lấy tin nhắn đã bị xóa hoàn toàn
            ->orderBy('sent_at', 'asc')
            ->get();
        
        // Lọc ra những tin nhắn chưa bị người dùng hiện tại xóa
        $filteredMessages = $messages->reject(function($message) use ($currentUserId) {
            return $message->isDeletedBy($currentUserId);
        });
        
        return response()->json(['messages' => $filteredMessages->values()]);
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

    public function deleteConversation(User $user)
    {
        $currentUserId = Auth::id();
        
        // Lấy tất cả tin nhắn trong cuộc trò chuyện
        $messages = Message::where(function($query) use ($user, $currentUserId) {
                $query->where('sender_user_id', $currentUserId)
                    ->where('recipient_user_id', $user->id);
            })
            ->orWhere(function($query) use ($user, $currentUserId) {
                $query->where('sender_user_id', $user->id)
                    ->where('recipient_user_id', $currentUserId);
            })
            ->get();
        
        // Đánh dấu từng tin nhắn là đã xóa bởi người dùng hiện tại
        foreach ($messages as $message) {
            $message->markAsDeletedBy($currentUserId);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Cuộc trò chuyện đã được xóa thành công.'
        ]);
    }
}