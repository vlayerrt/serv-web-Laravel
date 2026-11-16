<!doctype html>
<html lang="ru" data-bs-theme="light">
<head>
    <title>Новости на Laravel</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header><nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Новости</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="mainNav"><ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('article.index') }}">Статьи</a></li>
        @auth
            @if(auth()->user()->role_id == 1)
                <li class="nav-item"><a class="nav-link" href="{{ route('article.create') }}">Создать статью</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('comments.pending') }}">Модерация</a></li>
            @endif
        @endauth
        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">О нас</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/contacts') }}">Контакты</a></li>
    </ul><ul class="navbar-nav ms-auto align-items-lg-center">
        @auth
            <li id="notifications-menu" class="nav-item dropdown"></li>
            <li class="nav-item"><form method="post" action="{{ route('logout') }}">@csrf<button class="nav-link border-0 bg-transparent">Выйти</button></form></li>
        @else
            <li class="nav-item"><a class="nav-link" href="/auth/create">Регистрация</a></li><li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Войти</a></li>
        @endauth
    </ul></div>
</div></nav></header>
<main class="container py-4">
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    <div id="app"></div>
    @yield('content')
</main>
<footer class="border-top py-3"><div class="container text-muted small">Ершов Владислав Владимирович · Группа 257-321</div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
