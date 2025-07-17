<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ... (kode method index Anda tetap sama)
        $posts = Post::with('user')->latest()->get();

        if (Auth::check()) {
            if (Auth::user()->account_type == 'kreator') {
                return view('gallerykreator', ['posts' => $posts]);
            } elseif (Auth::user()->account_type == 'perusahaan') {
                return view('galleryperusahaan', ['posts' => $posts]);
            }
        }
        return view('galleryguest', ['posts' => $posts]);

        $posts = Post::with('user', 'likes', 'comments')->latest()->get();
        return view('gallerykreator', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createpost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string', // 'nullable' berarti boleh kosong
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);

        // 2. Handle upload file
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        // 3. Buat postingan baru dengan data yang sudah divalidasi
        // Karena 'description' ada di dalam $validated, ia akan ikut tersimpan.
        $request->user()->posts()->create($validated);

        return redirect()->route('gallery.index')->with('success', 'Karya berhasil diposting!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('user.kreatorProfile', 'comments.user.kreatorProfile', 'likes');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Sekarang baris ini akan berfungsi dengan benar
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('success', 'Karya berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('gallery.index')->with('success', 'Karya berhasil dihapus.');
    }
}
