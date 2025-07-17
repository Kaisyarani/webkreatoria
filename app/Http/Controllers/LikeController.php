<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
        $user = Auth::user();

        // Toggle: jika sudah ada, hapus. jika belum, buat.
        $user->likes()->toggle($post->id);

        return response()->json([
            'likes_count' => $post->likes()->count(),
            'user_has_liked' => $user->likes()->where('post_id', $post->id)->exists()
        ]);
    }
}
