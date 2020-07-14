<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow p-3 mb-5 rounded">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ route('root') }}">
            LaraBBS
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="nav mr-auto nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if (request()->url() == route('topics.index')) active @endif" href="{{ route('topics.index') }}">Topics</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if (request()->url() == route('categories.show', 1)) active @endif" href="{{ route('categories.show', 1) }}">Share</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if (request()->url() == route('categories.show', 2)) active @endif" href="{{ route('categories.show', 2) }}">Lesson</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if (request()->url() == route('categories.show', 3)) active @endif" href="{{ route('categories.show', 3) }}">Q&A</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if (request()->url() == route('categories.show', 4)) active @endif" href="{{ route('categories.show', 4) }}">Notice</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ url(Auth::user()->avatar) }}" class="img-responsive img-circle" width="30px" height="30px" alt="img">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
                                <ion-icon name="person-circle-outline"></ion-icon>
                                个人中心
                            </a>
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
                                <ion-icon name="create-outline"></ion-icon>
                                编辑资料
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Confirm Quit?')">
                                    {{ csrf_field() }}
                                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                </form>
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
</header>
