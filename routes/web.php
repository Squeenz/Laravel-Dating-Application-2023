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
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffReportController;
use App\Http\Controllers\StaffSuspensionController;
use App\Http\Controllers\StaffUserController;
use App\Http\Controllers\SupportTicketChatRoomMessagesController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\SuspensionController;
use App\Models\SupportTicketChatRoomMessages;
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

Route::get('/', function(){
    return redirect(route('page.index', 'home'));
});

Route::get('/page/{slugName}', [PageController::class, 'index'])->name('page.index');
Route::get('/policies', [PolicyController::class, 'index'])->name('policies.index');
Route::get('/policies/{policy}', [PolicyController::class, 'show'])->name('policies.show');

Route::middleware(['auth', 'verified', 'checkPhotos'])->group(function() {
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::get('/suspended', [SuspensionController::class, 'index'])->name('suspended.index');

    Route::get('/support/tickets', [SupportTicketController::class, 'index'])->name('support.index');

    Route::get('/support/ticket/chat/{supportTicket}', [SupportTicketController::class, 'show'])->name('support.show');
    Route::post('/support/message/send', [SupportTicketChatRoomMessagesController::class, 'store'])->name('support.message.store');

    Route::get('/support', [SupportTicketController::class, 'create'])->name('support.create');
    Route::post('/support/create', [SupportTicketController::class, 'store'])->name('support.store');
});

Route::middleware(['auth', 'verified', 'checkPhotos', 'checkSuspension'])->group(function() {
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/photos/remove', [PhotoController::class, 'remove'])->name('photos.remove');
});

Route::middleware(['auth', 'verified', 'checkPhotos', 'checkSuspension'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification');
    Route::post('/notifications/create', [NotificationController::class, 'store'])->name('notification.store');
    Route::post('/notifications', [NotificationController::class, 'readNotifications'])->name('notification.read.all');
    Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notification.destroy.all');
});

//Matchmaking system routes
Route::middleware(['auth', 'verified', 'checkPhotos', 'checkSuspension'])->group(function() {
    Route::get('/matches', [MatchingController::class, 'index'])->name('matches');
    Route::get('/matchmaking', [MatchingController::class, 'matchmaking'])->name('matchmaking');
    Route::post('/matchmaking', [MatchingController::class, 'store'])->name('matchmaking.store');
    Route::post('/like/{status}', [LikeController::class, 'store'])->name('like.store');
});

Route::middleware(['auth', 'verified', 'checkSuspension'])->group(function() {
    Route::get('/photos/get/{filename}', [PhotoController::class, 'getPrivatePhotos'])->name('photos.get');
    Route::delete('/photos/destroy/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
    Route::get('/photos/add', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos/upload', [PhotoController::class, 'store'])->name('photos.store');
});

//ChatApplication
Route::middleware(['auth', 'verified', 'checkPhotos', 'checkSuspension'])->group(function(){
    Route::get('/chat', [ChatApplicationController::class, 'index'])->name('chat.app');
    Route::get('/chat/{roomName}', [ChatApplicationController::class, 'show'])->name('chat.app.show');
    Route::post('/chat/message', [ChatMessageController::class, 'store'])->name('chat.store');
    Route::post('/chat/room', [ChatRoomController::class, 'store'])->name('chat.room.store');
});

//Staff routes
Route::middleware(['auth', 'checkSuspension'])->group(function(){
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.dashboard');

    //Page System Routes
    Route::get('/staff/pages', [PageController::class, 'create'])->name('staff.dashboard.pages');
    Route::post('/staff/pages', [PageController::class, 'store'])->name('staff.dashboard.pages.store');
    Route::get('/staff/page/edit/{page}', [PageController::class, 'edit'])->name('staff.dashboard.pages.edit');
    Route::patch('/staff/page/update/{page}', [PageController::class, 'update'])->name('staff.dashboard.pages.update');
    Route::delete('/staff/page/delete/{page}', [PageController::class, 'destroy'])->name('staff.dashboard.pages.destroy');
    Route::post('/staff/page/display', [DisplayBlockController::class, 'store'])->name('staff.dashboard.pages.display.store');
    Route::post('/staff/page/content', [ContentController::class, 'store'])->name('staff.dashboard.pages.content.store');
    Route::delete('/staff/page/content/deleteRelative/{content}', [ContentController::class, 'destroyRelative'])->name('staff.dashboard.pages.content.destroyRelative');
    Route::delete('/staff/page/content/delete/{content}', [ContentController::class, 'destroy'])->name('staff.dashboard.pages.content.destroy');
    Route::patch('/staff/page/content/update/{content}', [ContentController::class, 'update'])->name('staff.dashboard.pages.content.update');

    //Policies System Routes
    Route::get('/staff/policies', [PolicyController::class, 'staffIndex'])->name('staff.dashboard.policies');
    Route::post('/staff/policies/create', [PolicyController::class, 'store'])->name('staff.dashboard.policies.store');
    Route::delete('/staff/policies/delete/{policy}', [PolicyController::class, 'destroy'])->name('staff.dashboard.policies.destroy');
    Route::patch('/staff/policies/update/{policy}', [PolicyController::class,  'update'])->name('staff.dashboard.policies.update');

    //User System Routes
    Route::get('/staff/users', [StaffUserController::class, 'index'])->name('staff.dashboard.users');
    Route::delete('/staff/{user}/delete', [StaffUserController::class, 'destroy'])->name('staff.dashboard.users.destroy');


    Route::get('/staff/users/reports', [StaffReportController::class, 'index'])->name('staff.dashboard.reports');
    Route::patch('/staff/users/{report}/update', [StaffReportController::class, 'update'])->name('staff.dashboard.report.update');

    Route::get('/staff/users/suspensions', [StaffSuspensionController::class, 'index'])->name('staff.dashboard.suspensions');
    Route::post('/staff/user/suspension', [StaffSuspensionController::class, 'store'])->name('staff.dashboard.suspension.store');
});

require __DIR__.'/auth.php';
