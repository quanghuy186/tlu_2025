<?php

// app/Http/Controllers/Admin/MessageController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index(Request $request)
    {
        $query = Message::with(['sender', 'recipient']);

        // Tìm kiếm
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Lọc theo trạng thái đọc
        if ($request->filled('is_read')) {
            $query->where('is_read', $request->is_read);
        }

        // Lọc theo loại tin nhắn
        if ($request->filled('message_type')) {
            $query->where('message_type', $request->message_type);
        }

        // Lọc theo người gửi
        if ($request->filled('sender_user_id')) {
            $query->where('sender_user_id', $request->sender_user_id);
        }

        // Lọc theo người nhận
        if ($request->filled('recipient_user_id')) {
            $query->where('recipient_user_id', $request->recipient_user_id);
        }

        // Lọc theo ngày
        if ($request->filled('date_from')) {
            $query->where('sent_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('sent_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Lọc tin nhắn đã xóa
        if ($request->filled('show_deleted') && $request->show_deleted == '1') {
            // Hiển thị tất cả kể cả đã xóa
        } else {
            $query->notDeleted();
        }

        // Sắp xếp
        $sortField = $request->get('sort_field', 'sent_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);

        // Phân trang
        $perPage = $request->get('per_page', 10);
        $messages = $query->paginate($perPage)->appends($request->all());

        // Lấy danh sách users cho dropdown
        $users = User::orderBy('name')->get();

        // Thống kê
        $statistics = [
            'total' => Message::count(),
            'unread' => Message::unread()->count(),
            'today' => Message::whereDate('sent_at', today())->count(),
            'deleted' => Message::where('is_deleted', true)->count(),
        ];

        return view('admin.messages.index', compact('messages', 'users', 'statistics'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create()
    {
        $users = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.messages.create', compact('users'));
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'message_type' => 'required|in:text,image,file,video',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['recipient_user_id', 'content', 'message_type']);
            $data['sender_user_id'] = auth()->id();

            // Xử lý upload file nếu có
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('messages', 'public');
                $data['file_url'] = Storage::url($path);
            }

            Message::create($data);

            DB::commit();
            return redirect()->route('admin.messages.index')
                ->with('success', 'Tin nhắn đã được gửi thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message)
    {
        // Mark as read if recipient is viewing
        if ($message->recipient_user_id == auth()->id() && !$message->is_read) {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Show the form for editing the message.
     */
    public function edit(Message $message)
    {
        // Chỉ cho phép chỉnh sửa nếu là người gửi và tin nhắn chưa được đọc
        if ($message->sender_user_id != auth()->id() || $message->is_read) {
            return redirect()->route('admin.messages.index')
                ->with('error', 'Không thể chỉnh sửa tin nhắn này!');
        }

        $users = User::where('is_active', true)->orderBy('name')->get();
        return view('admin.messages.edit', compact('message', 'users'));
    }

    /**
     * Update the specified message.
     */
    public function update(Request $request, Message $message)
    {
        // Chỉ cho phép chỉnh sửa nếu là người gửi và tin nhắn chưa được đọc
        if ($message->sender_user_id != auth()->id() || $message->is_read) {
            return redirect()->route('admin.messages.index')
                ->with('error', 'Không thể chỉnh sửa tin nhắn này!');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $message->update($request->only(['content']));

        return redirect()->route('admin.messages.index')
            ->with('success', 'Tin nhắn đã được cập nhật!');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(Message $message)
    {
        // Soft delete
        $message->softDelete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Tin nhắn đã được xóa!');
    }

    /**
     * Bulk delete messages
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|string',
        ]);

        $messageIds = explode(',', $request->message_ids);
        
        Message::whereIn('id', $messageIds)->update(['is_deleted' => true]);

        return redirect()->route('admin.messages.index')
            ->with('success', 'Đã xóa ' . count($messageIds) . ' tin nhắn!');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        $message->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark message as unread
     */
    public function markAsUnread(Message $message)
    {
        $message->markAsUnread();

        return response()->json(['success' => true]);
    }

    /**
     * Restore deleted message
     */
    public function restore(Message $message)
    {
        $message->restore();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Tin nhắn đã được khôi phục!');
    }

    /**
     * Get statistics
     */
    public function statistics()
    {
        $statistics = [
            'messages_by_type' => Message::select('message_type', DB::raw('count(*) as count'))
                ->groupBy('message_type')
                ->get(),
            'messages_by_day' => Message::select(DB::raw('DATE(sent_at) as date'), DB::raw('count(*) as count'))
                ->where('sent_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'top_senders' => Message::select('sender_user_id', DB::raw('count(*) as count'))
                ->with('sender')
                ->groupBy('sender_user_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
            'top_recipients' => Message::select('recipient_user_id', DB::raw('count(*) as count'))
                ->with('recipient')
                ->groupBy('recipient_user_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return view('admin.messages.statistics', compact('statistics'));
    }
}