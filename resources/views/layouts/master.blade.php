<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <meta name="description" content="">
  <link rel="icon" href="" sizes="" type="image/png">
  <!-- スマホ用アイコン画像 -->
  <link rel="apple-touch-icon-precomposed" href="">
  <title>メディア投稿サイト -@yield('title')-</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
</head>

<body>
@if(Session::has('message'))
<div class="c-session-msg js-show-msg">
  {{ session('message') }}
</div>
@endif

  <header class="p-header" id="header">
    <div class="p-header__title">
    <a href="{{ route('home') }}" style="color:#fff"><!-- リファクタリング -->
      MEDIA
    </a>
    </div>
    <nav class="p-header__nav">
      <ul class="p-menu">
        @if(!Auth::check())
        <li class="p-menu-item"><a href="{{ route('user.signup') }}" class="p-menu-link">サインイン</a></li>
        <li class="p-menu-item"><a href="{{ route('user.login') }}" class="p-menu-link">ログイン</a></li>
        
        @else
        <li class="p-menu-item"><a href="{{ route('user.mypage') }}" class="p-menu-link">マイページ</a></li>
        <li class="p-menu-item"><a href="{{ route('user.logout') }}" class="p-menu-link">ログアウト</a></li>
        @endif
      </ul>
    </nav>
  </header>

  @yield('content')

  <footer class="p-footer js-footer" id="footer">
    &copy;All Rights Reserve.
  </footer>
  <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
