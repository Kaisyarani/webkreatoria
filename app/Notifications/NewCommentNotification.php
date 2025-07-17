<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Comment; // Ganti dengan model Anda

class NewCommentNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database']; // Kita ingin menyimpannya ke database
    }

    public function toArray($notifiable)
    {
        // Data inilah yang akan disimpan di kolom 'data' pada tabel notifikasi
        return [
            'comment_id' => $this->comment->id,
            'commenter_name' => $this->comment->user->name,
            'post_title' => $this->comment->post->title,
            'post_id' => $this->comment->post->id,
        ];
    }
}

