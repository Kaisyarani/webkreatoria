<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\ChatMessageSent;


class ChatPage extends Component
{
    public $selectedReceiverId = null;

    protected $listeners = ['start-chat' => 'setReceiver'];

    public function setReceiver($receiverId)
    {
        $this->selectedReceiverId = $receiverId;
    }

    public function render()
    {
        return view('livewire.chat-page');
    }
}
