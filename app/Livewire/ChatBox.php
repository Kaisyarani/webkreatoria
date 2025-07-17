<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;

class ChatBox extends Component
{
    public $receiverId;
    public $receiver;
    public $messages = [];
    public $content = ''; // pastikan nama ini sesuai dengan wire:model

    protected $listeners = ['start-chat' => 'loadChat'];


    public function loadChat($receiverId)
    {
        $this->receiverId = $receiverId;
        $this->receiver = \App\Models\User::find($receiverId);
        $this->messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', auth()->id())
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', auth()->id());
        })->orderBy('created_at')->get();
    }

    public function sendMessage()
    {
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiverId,
            'message' => $this->content,
        ]);

        $this->content = '';
        $this->loadChat($this->receiverId);
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
