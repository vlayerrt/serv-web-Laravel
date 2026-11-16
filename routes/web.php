<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\TrackArticleView;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::get('/about', fn () => view('main.about'));
Route::get('/contacts', function () {
    $contact = ['name' => 'Политех', 'address' => 'Б. Семеновская', 'phone' => '+7-(495)-012-34-56', 'email' => '@mospolytech.ru'];
    return view('main.contacts', ['contacts' => $contact]);
});
Route::get('/gallery/{full_image}', [MainController::class, 'show']);

Route::middleware('auth')->group(function () {
    Route::resource('article', ArticleController::class)->except(['index', 'show']);
    Route::post('/article/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/moderation/comments', [CommentController::class, 'pending'])->name('comments.pending');
    Route::patch('/moderation/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/moderation/comments/{comment}', [CommentController::class, 'reject'])->name('comments.reject');
    Route::get('/notifications/unread', function () {
        return auth()->user()->unreadNotifications
            ->map(fn ($notification) => [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? 'Новая статья',
                'url' => route('notifications.read', $notification),
            ])->values();
    })->name('notifications.unread');

    Route::get('/notifications/{notification}/read', function (\Illuminate\Notifications\DatabaseNotification $notification) {
        abort_unless($notification->notifiable_id === auth()->id(), 403);
        $notification->markAsRead();
        return redirect($notification->data['url'] ?? route('article.index'));
    })->name('notifications.read');
});

Route::resource('article', ArticleController::class)->only(['index', 'show'])->middleware('track.article.view');

Route::get('/auth/create', [AuthController::class, 'create']);
Route::post('/auth/signUp', [AuthController::class, 'signUp']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/signIn', [AuthController::class, 'customLogin']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('auth');
