@extends('layouts.master')
@section('title', 'パスワード再設定ページ')
@section('content')

<div class="c-container">
    <h2 class="c-container__title">パスワード再設定ページ</h2>
    <form action="{{ url('password/reset') }}" method="post" class="p-form">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">
          
        </div>

        <input type="hidden" name="token" value="{{ $token }}">

        <label for="" class="p-form-group">
          メールアドレス
          <input type="email" name="email" value="{{ $email or old('email') }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('email') }}
        </div>

        <label for="" class="p-form-group">
          パスワード
          <input type="password" name="password" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('password') }}
        </div>

        <label for="" class="p-form-group">
          パスワード（再入力）
          <input type="password" name="password_confirmation"  class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('password_confirmation') }}
        </div>

        <button type="submit" value="送信" class="c-btn-submit">パスワードをリセット</button>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
@endsection