<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string']);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        // Kirim notifikasi ke pemilik postingan,
        // HANYA JIKA yang berkomentar bukan pemilik postingan itu sendiri.
        if ($post->user->id !== auth()->id()) {
            $post->user->notify(new NewCommentNotification($comment));
        }

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}

