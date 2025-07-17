<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatMessageSent;

class ChatRoom extends Component
{
    public $receiverId;
    public $messageText;
    public $messages = [];

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::where(function ($query) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $this->receiverId);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->receiverId)
                  ->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();
    }

    public function sendMessage()
    {
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'message' => $this->messageText,
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();
        $this->messageText = '';
        $this->loadMessages();
    }

    protected function getListeners()
{
    return [
        "echo:chat.{$this->receiverId},message.sent" => 'loadMessages',
    ];
}

    public function render()
    {
        return view('livewire.chat-room');
    }
}
