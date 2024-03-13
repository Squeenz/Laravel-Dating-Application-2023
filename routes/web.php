<?php

use App\Http\Controllers\ChatApplicationController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DisplayBlockController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffUserController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/', function() {
//     return Inertia::render('Landing', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('home');

// Route::get('/policies', function() {
//     return Inertia::render('Policies/Policies', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('policies');

// Route::get('/policies/show', function() {
//     return Inertia::render('Policies/Show', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('policies.show');

// Route::get('/how-to-stay-safe', function() {
//     return Inertia::render('Safe', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('safe');

// Route::get('/support', function() {
//     return Inertia::render('Support/Main', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//     ]);
// })->name('support');

Route::get('/', function(){
    return redirect(route('page.index', 'home'));
});

Route::get('/page/{slugName}', [PageController::class, 'index'])->name('page.index');

Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function() {
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/photos/remove', [PhotoController::class, 'remove'])->name('photos.remove');
});

Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification');
    Route::post('/notifications/create', [NotificationController::class, 'store'])->name('notification.store');
    Route::post('/notifications', [NotificationController::class, 'readNotifications'])->name('notification.read.all');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notification.destroy.all');
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

Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function(){
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.dashboard');
    //Staff page control
    Route::get('/staff/pages', [PageController::class, 'create'])->name('staff.dashboard.pages');
    Route::post('/staff/pages', [PageController::class, 'store'])->name('staff.dashboard.pages.store');

    Route::get('/staff/page/edit/{page}', [PageController::class, 'edit'])->name('staff.dashboard.pages.edit');
    Route::post('/staff/page/layout', [DisplayBlockController::class, 'store'])->name('staff.dashboard.pages.display.store');
    Route::delete('/staff/page/layout/content/delete/{content}', [ContentController::class, 'destroy'])->name('staff.dashboard.pages.content.destroy');

    Route::patch('/staff/page/update/{page}', [PageController::class, 'update'])->name('staff.dashboard.pages.update');
    Route::delete('/staff/page/delete/{page}', [PageController::class, 'destroy'])->name('staff.dashboard.pages.destroy');


    //Staff user control
    Route::get('/staff/users', [StaffUserController::class, 'index'])->name('staff.dashboard.users');
    Route::delete('/staff/{user}/delete', [StaffUserController::class, 'destroy'])->name('staff.dashboard.users.destroy');
});

require __DIR__.'/auth.php';
