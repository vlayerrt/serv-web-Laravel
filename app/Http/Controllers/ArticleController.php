<?php

namespace App\Http\Controllers;

use App\Events\NewArticleEvent;
use App\Jobs\VeryLongJob;
use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Cache::remember('articles:page:'.request('page', 1), now()->addMinutes(10), fn () => Article::latest()->paginate(5));
        return view('articles.index', compact('articles'));
    }

    public function create() { $this->authorize('article'); return view('articles.create'); }

    public function store(Request $request)
    {
        $this->authorize('article');
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
        if (config('app.legacy_article_mail', false)) VeryLongJob::dispatch($article);
        return redirect()->route('article.show', $article)->with('status', 'Статья добавлена.');
    }

    public function show(Article $article)
    {
        $cachedArticle = Cache::rememberForever('article:'.$article->id, fn () => $article->load(['comments' => fn ($query) => $query->where('is_approved', true)->with('user')->latest()]));
        return view('articles.show', ['article' => $cachedArticle]);
    }

    public function edit(Article $article) { $this->authorize('article'); return view('articles.edit', compact('article')); }

    public function update(Request $request, Article $article)
    {
        $this->authorize('article');
        $article->update($request->validate([
            'datePublic' => ['required', 'date'], 'title' => ['required', 'string', 'max:255'],
            'shortDesc' => ['nullable', 'string', 'max:255'], 'desc' => ['required', 'string'],
        ]));
        Cache::forget('article:'.$article->id);
        Cache::flush();
        return redirect()->route('article.show', $article)->with('status', 'Статья обновлена.');
    }

    public function destroy(Article $article)
    {
        $this->authorize('article');
        Cache::forget('article:'.$article->id);
        Cache::flush();
        $article->delete();
        return redirect()->route('article.index')->with('status', 'Статья удалена.');
    }
}
