@extends('layouts.master')
@section('title', '管理者用ログインページ')
@section('content')

  <div class="c-container">
    <h2 class="c-container__title">管理者用ログイン</h2>
    <form action="" method="post" class="p-form">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">
          
        </div>
        <label for="" class="p-form-group">
          メールアドレス
          <input type="text" name="email" value="{{ old('email') }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('email') }}
        </div>

        <label for="" class="p-form-group">
          パスワード
          <input type="password" name="pass" value="{{ old('pass') }}"  class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('pass') }}
        </div>

        <label class="p-form-group">
          <input type="checkbox" name="remember_me" value="1" class="p-form-control p-form-check">
          <span class="p-form-check-part">次回以降、ログインを省略する</span>
        </label>

        <button type="submit" value="送信" class="c-btn-submit">送信</button>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
@endsection
