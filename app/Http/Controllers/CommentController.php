<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:2000']]);
        $article->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
            'is_approved' => false,
        ]);
        Cache::forget('article:'.$article->id);

        return back()->with('status', 'Комментарий отправлен и ожидает модерации.');
    }

    public function pending()
    {
        abort_unless(auth()->user()?->role_id == 1, 403);
        $comments = Comment::with(['article', 'user'])->where('is_approved', false)->latest()->paginate(10);
        return view('comments.pending', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        abort_unless(auth()->user()?->role_id == 1, 403);
        $comment->update(['is_approved' => true]);
        Cache::forget('article:'.$comment->article_id);
        return back()->with('status', 'Комментарий опубликован.');
    }

    public function reject(Comment $comment)
    {
        abort_unless(auth()->user()?->role_id == 1, 403);
        $articleId = $comment->article_id;
        $comment->delete();
        Cache::forget('article:'.$articleId);
        return back()->with('status', 'Комментарий отклонён и удалён.');
    }
}
