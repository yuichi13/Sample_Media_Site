@extends('layouts.master')
@section('title', '新規登録ページ')
@section('content')
<div class="c-container">
    <h2 class="c-container__title">新規登録</h2>
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
          <input type="password" name="pass" value="{{ old('pass') }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
        {{ $errors->first('pass') }}
        </div>

        <label for="" class="p-form-group">
          パスワード（再入力）
          <input type="password" name="pass_confirmation" value="{{ old('pass_confirmation') }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
        {{ $errors->first('pass_confirmation') }}
        </div>

        <button type="submit" value="送信" class="c-btn-submit">送信</button>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
  @endsection