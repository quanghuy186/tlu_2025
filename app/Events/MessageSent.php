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

class MessageSent implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // public function broadcastOn()
    // {
    //     return new PrivateChannel('chat.' . $this->message->recipient_user_id);
    // }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message->recipient_user_id);
    }
     
    
    /**
     * Tên cho sự kiện broadcast
     */
    public function broadcastAs()
    {
        return 'message.sent';
    }
    
    /**
     * Dữ liệu để broadcast
     */
    public function broadcastWith()
    {
        // Đảm bảo message có thông tin người gửi
        $this->message->load('sender');
        
        return [
            'message' => $this->message
        ];
    }

    

    // use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $message;

    // public function __construct(Message $message)
    // {
    //     $this->message = $message;
    // }

    // public function broadcastOn()
    // {
    //     return new PrivateChannel('chat.' . $this->message->recipient_user_id);
    // }
}