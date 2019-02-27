@extends('layouts.master')
@section('title', 'パスワード変更ページ')
@section('content')

<div class="c-container-fluid">
    <h2 class="c-container__title">パスワード変更</h2>
    <div id="container-2column">
    <main class="c-main" id="main">
    <form action="" method="post" class="p-form-fluid p-pass-edit">
      <div class="p-form-wrapper p-pass-edit-wrapper">
        <div class="p-form-area-msg">
          @if(Session::has('errormsg')) {{ session('errormsg') }} @endif
        </div>
        <label for="" class="p-form-group">
          古いパスワード
          <input type="password" name="pass_old" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('pass_old') }}
        </div>

        <label for="" class="p-form-group">
          新しいパスワード
          <input type="password" name="pass_new" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('pass_new') }}
        </div>

        <label for="" class="p-form-group">
          新しいパスワード（再入力）
          <input type="password" name="pass_new_confirmation" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('pass_confirmation') }}
        </div>

        <button type="submit" value="送信" class="c-btn-submit">送信</button>
      </div>
      {{ csrf_field() }}
    </form>
</main>
    @include('layouts.sidebar_menu')
    </div>
  </div>

@endsection