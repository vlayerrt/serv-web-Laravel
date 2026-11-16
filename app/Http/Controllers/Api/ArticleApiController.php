<?php

namespace App\Http\Controllers\Api;

use App\Events\NewArticleEvent;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class ArticleApiController extends Controller
{
    public function index() { return response()->json(Article::latest()->paginate(10)); }
    public function show(Article $article)
    {
        $article->load(['comments' => fn ($query) => $query
            ->where('is_approved', true)
            ->with('user')
            ->latest()]);

        return response()->json($article);
    }

    public function store(Request $request)
    {
        abort_unless($request->user()?->role_id == 1, 403);
        $data = $request->validate([
            'datePublic' => ['required', 'date'], 'title' => ['required', 'string', 'max:255'],
            'shortDesc' => ['nullable', 'string', 'max:255'], 'desc' => ['required', 'string'],
        ]);
        $article = Article::create($data);
        Cache::flush();
        $readers = User::query()
            ->where(function ($query) {
                $query->where('role_id', 2)->orWhereNull('role_id');
            })
            ->whereKeyNot(auth()->id())
            ->get();
        Notification::send($readers, new NewArticleNotification($article));
        event(new NewArticleEvent($article));
        return response()->json($article, 201);
    }

    public function update(Request $request, Article $article)
    {
        abort_unless($request->user()?->role_id == 1, 403);
        $article->update($request->validate([
            'datePublic' => ['sometimes', 'date'], 'title' => ['sometimes', 'string', 'max:255'],
            'shortDesc' => ['nullable', 'string', 'max:255'], 'desc' => ['sometimes', 'string'],
        ]));
        Cache::forget('article:'.$article->id);
        Cache::flush();

        return response()->json($article->fresh());
    }

    public function destroy(Request $request, Article $article)
    {
        abort_unless($request->user()?->role_id == 1, 403);
        Cache::forget('article:'.$article->id);
        Cache::flush();
        $article->delete();

        return response()->json(['message' => 'Статья удалена.']);
    }
}
