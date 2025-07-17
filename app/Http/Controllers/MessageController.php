<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\User;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $message = Message::create([
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
    

    public function index(Request $request)
{
    $user = auth()->user();

    $contacts = User::where('id', '!=', $user->id)
        ->with(['kreatorProfile', 'lastMessage']) // relasi custom
        ->get()
        ->map(function ($contact) use ($user) {
            $contact->unread_count = Message::where('sender_id', $contact->id)
                ->where('receiver_id', $user->id)
                ->where('read', false)
                ->count();

            return $contact;
        });

    return view('chat.index', [
        'contacts' => $contacts,
        'chatWithUser' => null // atau isi kalau ada user yang dibuka
    ]);
}
}

