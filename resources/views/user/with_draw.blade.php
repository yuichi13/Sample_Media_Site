@extends('layouts.master')
@section('title', '退会ページ')
@section('content')

<div class="c-container">
    <h2 class="c-container__title">退会</h2>
    <form action="" method="post" class="p-form">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">

        </div>
        本当に退会しますか？ボタンを押すと退会します。
        <button type="submit" name="withdraw" value="1" class="c-btn-submit">退会する</button>
      </div>
      {{ csrf_field() }}
    </form>
  </div>

  @endsection