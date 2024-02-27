<?php

use App\Http\Controllers\ChatApplicationController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/photos/remove', [PhotoController::class, 'remove'])->name('photos.remove');
});

Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification');
});

//Matchmaking system routes
Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function() {
    Route::get('/matches', [MatchingController::class, 'index'])->name('matches');
    Route::get('/matchmaking', [MatchingController::class, 'matchmaking'])->name('matchmaking');
    Route::post('/matchmaking', [MatchingController::class, 'store'])->name('matchmaking.store');
    Route::post('/like/{status}', [LikeController::class, 'store'])->name('like.store');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/photos/get/{filename}', [PhotoController::class, 'getPrivatePhotos'])->name('photos.get');
    Route::delete('/photos/destroy/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::get('/photos/add', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos/upload', [PhotoController::class, 'store'])->name('photos.store');
});

//ChatApplication
Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function(){
    Route::get('/chat', [ChatApplicationController::class, 'index'])->name('chat.app');
    Route::get('/chat/{roomName}', [ChatApplicationController::class, 'show'])->name('chat.app.show');
    Route::post('/chat/message', [ChatMessageController::class, 'store'])->name('chat.store');
    Route::post('/chat/room', [ChatRoomController::class, 'store'])->name('chat.room.store');
});

require __DIR__.'/auth.php';
