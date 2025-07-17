<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('user'); // Pastikan relasi 'user' ada di model
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'content' => $this->message->message, // atau 'text' sesuai kolom database kamu
                'user' => $this->message->user->only(['id', 'name']),
                'created_at' => $this->message->created_at->toDateTimeString(),
            ]
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
