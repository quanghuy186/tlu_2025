<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        Log::info('Broadcasting message', [
            'channel' => 'chat.' . $this->message->recipient_user_id,
            'message_id' => $this->message->id
        ]);
        return new PrivateChannel('chat.' . $this->message->recipient_user_id);
    }
    
    public function broadcastAs()
    {
        return 'message.sent';
    }
    
    public function broadcastWith()
    {
        // Đảm bảo message có thông tin người gửi
        $this->message->load('sender');
        
        return [
            'message' => $this->message
        ];
    }
}