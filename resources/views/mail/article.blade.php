<div class="container">
    <h1>{{ $article->title }}</h1>

    <p>{{ $article->shortDesc }}</p>

    @if ($article->desc)
        <p>{{ $article->desc }}</p>
    @endif

    <p>Дата публикации: {{ $article->datePublic }}</p>
</div>

