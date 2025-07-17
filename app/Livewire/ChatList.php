<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ChatList extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::where('id', '!=', auth()->id())->get();
    }

    public function startChat($receiverId)
    {
        $this->dispatch('start-chat', receiverId: $receiverId); // Ini format Livewire v3
    }

    public function render()
    {
        return view('livewire.chat-list');
    }
}

