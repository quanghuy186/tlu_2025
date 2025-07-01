<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }

    public function getMessages($userId)
    {
        // Lấy tin nhắn giữa người dùng hiện tại và người dùng đã chọn
        $messages = Message::where(function($query) use ($userId) {
                $query->where('sender_user_id', Auth::id())
                      ->where('recipient_user_id', $userId);
            })
            ->orWhere(function($query) use ($userId) {
                $query->where('sender_user_id', $userId)
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

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }

    public function markAsRead($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Chỉ người nhận mới có thể đánh dấu đã đọc
        if ($message->recipient_user_id == Auth::id()) {
            $message->is_read = true;
            $message->save();
        }
        
        return response()->json(['success' => true]);
    }

    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        if ($message->sender_user_id == Auth::id() || $message->recipient_user_id == Auth::id()) {
            $message->is_deleted = true;
            $message->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 403);
    }
}
