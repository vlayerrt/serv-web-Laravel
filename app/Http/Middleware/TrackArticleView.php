<?php

namespace App\Http\Middleware;

use App\Models\Article;
use App\Models\ArticleView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TrackArticleView
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $article = $request->route('article');
        if ($response->getStatusCode() < 400 && $article instanceof Article) {
            ArticleView::create([
                'article_id' => $article->id,
                'viewed_at' => Carbon::now(),
                'path' => $request->path(),
            ]);
        }
        return $response;
    }
}
