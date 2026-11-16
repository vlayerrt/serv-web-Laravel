@extends('layout')
@section('content')
<h1 class="h3 my-4">Комментарии на модерации</h1>
@forelse($comments as $comment)
    <div class="card mb-3"><div class="card-body">
        <div class="text-muted small">{{ $comment->user?->name ?? 'Гость' }} · <a href="{{ route('article.show', $comment->article) }}">{{ $comment->article->title }}</a></div>
        <p class="my-3">{{ $comment->body }}</p>
        <div class="d-flex gap-2">
            <form method="post" action="{{ route('comments.approve', $comment) }}">@csrf @method('PATCH')<button class="btn btn-success">Опубликовать</button></form>
            <form method="post" action="{{ route('comments.reject', $comment) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger">Отклонить</button></form>
        </div>
    </div></div>
@empty <p>Новых комментариев нет.</p> @endforelse
{{ $comments->links() }}
@endsection
