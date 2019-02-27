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
  <style>
  .p-admin-main {
    text-align: center;
  }
  </style>
</head>

<body>
@if(Session::has('message'))
<div class="c-session-msg js-show-msg">
  {{ session('message') }}
</div>
@endif

  <header class="p-header" id="header">
    <div class="p-header__title">
    <a href="{{ route('admin.user_list') }}" style="color:#fff"><!-- リファクタリング -->
      管理者用ページ
    </a>
    </div>
    <nav class="p-header__nav">
      <ul class="p-menu">
        
        <li class="p-menu-item"><a href="{{ route('admin.user_list') }}" class="p-menu-link">ユーザーリスト</a></li>
        <li class="p-menu-item"><a href="{{ route('admin.post_list') }}" class="p-menu-link">投稿記事リスト</a></li>
        <li class="p-menu-item"><a href="{{ route('admin.logout') }}" class="p-menu-link">ログアウト</a></li>
        
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
