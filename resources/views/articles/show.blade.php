@extends('layout')
@section('content')
<article class="card my-4"><div class="card-body">
    <div class="text-muted">{{ $article->datePublic }}</div>
    <h1 class="h3 card-title">{{ $article->title }}</h1>
    <h2 class="h6 text-secondary">{{ $article->shortDesc }}</h2>
    <p class="card-text">{{ $article->desc }}</p>
    @can('update', [\App\Http\Controllers\ArticleController::class])
        <a href="{{ route('article.edit', $article) }}" class="btn btn-outline-primary">Изменить</a>
        <form action="{{ route('article.destroy', $article) }}" method="post" class="d-inline">@csrf @method('DELETE')<button class="btn btn-outline-danger">Удалить</button></form>
    @endcan
</div></article>

<section class="mb-5">
    <h2 class="h4">Комментарии</h2>
    @if(session('status'))<div class="alert alert-info">{{ session('status') }}</div>@endif
    @forelse($article->comments as $comment)
        <div class="border rounded p-3 mb-2"><strong>{{ $comment->user?->name ?? 'Читатель' }}</strong><p class="mb-0">{{ $comment->body }}</p></div>
    @empty <p class="text-secondary">Пока нет опубликованных комментариев.</p> @endforelse
    @auth
        <form method="post" action="{{ route('comments.store', $article) }}" class="mt-3">@csrf
            <label class="form-label" for="comment-body">Оставить комментарий</label>
            <textarea class="form-control mb-2" id="comment-body" name="body" rows="3" required>{{ old('body') }}</textarea>
            @error('body')<div class="text-danger mb-2">{{ $message }}</div>@enderror
            <button class="btn btn-primary">Отправить на модерацию</button>
        </form>
    @else <p><a href="{{ route('login') }}">Войдите</a>, чтобы оставить комментарий.</p>@endauth
</section>
@endsection
