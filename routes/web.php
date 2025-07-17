<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ChatController;
use App\Livewire\ChatRoom;
use App\Livewire\ChatList;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// RUTE BARU UNTUK DASHBOARD BERDASARKAN PERAN
Route::middleware(['auth', 'verified'])->group(function () {
    // Rute untuk dashboard utama yang akan mengarahkan berdasarkan peran
    Route::get('/dashboard', function () {
        if (Auth::user()->account_type == 'perusahaan') {
            return redirect()->route('perusahaan.dashboard');
        }
        return redirect()->route('kreator.dashboard');
    })->name('dashboard');

    // Rute spesifik untuk setiap peran
    Route::get('/dashboard/kreator', function () {
        return view('kreator');
    })->name('kreator.dashboard');

    Route::get('/dashboard/perusahaan', function () {
        return view('perusahaan');
    })->name('perusahaan.dashboard');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/explore', [TalentController::class, 'index'])->name('explore.index');
    Route::get('/explore', [TalentController::class, 'index'])->name('explore.index');
    Route::get('/explore/ai-assistant', [TalentController::class, 'aiAssistant'])->name('explore.ai-assistant');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike'])->name('posts.like');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::get('/chat/{user}', [ChatController::class, 'chatWith'])->name('chat.with');
    Route::get('/chat/room/{receiverId}', ChatRoom::class)->name('chat');
     Route::get('/chat', ChatList::class)->name('chat.list');
     Route::get('/chat', [MessageController::class, 'index'])->middleware('auth')->name('chat');
Route::post('/chat/send', [MessageController::class, 'store'])->middleware('auth')->name('chat.send');
});

Route::get('/gallery', [PostController::class, 'index'])->name('gallery.index');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/profile/{user}', [UserProfileController::class, 'show'])->name('profile.show');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

require __DIR__.'/auth.php';
