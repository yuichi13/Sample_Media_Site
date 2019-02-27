@extends('layouts.master')
@section('title', 'パスワードリセット')
@section('content')

<div class="c-container">
    <h2 class="c-container__title">パスワードリセット用Eメール送信ページ</h2>
    <form action="{{ route('password.email') }}" method="post" class="p-form">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">
          
        </div>
        <label for="" class="p-form-group">
          メールアドレス
          <input type="email" name="email" value="{{ old('email') }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('email') }}
        </div>

        <button type="submit" value="送信" class="c-btn-submit">送信</button>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
@endsection