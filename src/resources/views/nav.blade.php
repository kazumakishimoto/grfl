<nav class="navbar navbar-expand-md navbar-dark sunny-morning-gradient">
    <div class="container">
        <a class="navbar-brand" href="/">circle_test</a>

        <!-- スマホやタブレットで表示した時のメニューボタン -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">

            <!-- 検索フォーム -->
            <li class="nav-item">
                <form method="GET" action="{{ route('articles.search') }}" class="d-flex">
                    <input class="form-control" name="search" type="text" placeholder="検索..." aria-label="Search">
                    <button class="input-group-text border-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li>

            @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">ユーザー登録</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">ログイン</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('login.guest') }}" class="text-white">ゲストログイン</a></li>
            @endguest

            @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿</a></li>
            <div class="d-none d-md-block">
                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-circle"></i></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <button class="dropdown-item" type="button" onclick="location.href='{{ route("users.show", ["name" => Auth::user()->name]) }}'">マイページ</button>
                        <div class="dropdown-divider"></div>
                        <button form="logout-button" class="dropdown-item" type="submit">ログアウト</button>
                    </div>
                </li>
                <form id="logout-button" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
                <!-- Dropdown -->
            </div>

            <!-- sp -->
            <div class="d-block d-md-none">
                <li class="nav-item mt-2"><a class="nav-link" href="{{ route("users.show", ["name" => Auth::user()->name]) }}"><i class="fas fa-user mr-1"></i>マイページ</a></li>
                <li class="nav-item mt-2">
                    <form name="logout" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link" href="javascript:logout.submit()"><i class="fas fa-sign-out-alt mr-1"></i>ログアウト</a>
                    </form>
                </li>
            </div>
            <form id="logout-button" method="POST" action="{{ route('logout') }}">
                @csrf
            </form>
            @endauth
        </ul>
    </div>
</nav>
