<!doctype html> 
<html lang="en" data-bs-theme="dark">
    <head>
        <title>Новости</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">Главная</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" @if(request()->is('about')) aria-current="page" @endif href="{{ url('/about') }}">О нас</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ request()->is('contacts') ? 'active' : '' }}" @if(request()->is('contacts')) aria-current="page" @endif href="{{ url('/contacts') }}">Контакты</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ request()->is('/article/show') ? 'active' : '' }}" @if(request()->is('/article/show')) aria-current="page" @endif href="{{ url('/article/show') }}">Статьи</a>
                        </li>
                                            
                    </ul>
                    <form class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            <a class="nav-link" href="/signup">Регистрация</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="/auth/login">Войти</a>
                            </li>
                        </ul>
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    </div>
                </div>
                </nav>
        </header>
        <main class="flex-shrink-0">
            <div class="container">
                @yield('content')
            </div>
        </main>
        <footer class="footer mt-auto py-3 bg-dark">
        <div class="container fixed-bottom">
            <span class="text-muted">Ершов Владислав Владимирович</span>
            <span class="text-muted">Группа 257-321</span>
        </div>
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
