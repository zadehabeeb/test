<?php

namespace App\Events\Test;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicChannelTest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    Public $message;
    Public $user;
    /**
     * Create a new event instance.
     */
    public function __construct(Message $message, User $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
    public function brodcastWith()
    {
        return [
            'message' => $this->message,
            'user' => $this->user,
            'channel_type' => 'public',
            'timestamp' => now()->timestamp,
            'info' => 'This is a public channel event',
        ];
    }
    public function broadcastAs()
    {
        return 'publicChannelTest';
    }
}
