<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    // Constructor
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    // Define the channel the event will broadcast on
    public function broadcastOn()
    {
        return new Channel('chat.' . $this->message->receiver_id);
    }

    // Define the broadcast format
    public function broadcastWith()
    {
        return [
            'sender' => $this->message->sender->username, // Assuming 'username' is the column for users
            'content' => $this->message->content,
        ];
    }
}
