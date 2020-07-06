<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Weibo App')</title>
    <link rel="stylesheet" href="{{asset('/')}}/css/app.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Weibo App</a>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item"><a class="nav-link" href="/help">help</a> </li>
                <li class="nav-item"><a class="nav-link" href="/about">about</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @yield('content');
    </div>
</body>
</html>
