@extends('layouts.master')
@section('title', 'プロフィール編集ページ')
@section('content')

<div class="c-container-fluid">
    <h2 class="c-container__title">プロフィール編集</h2>
    <div id="container-3column">
    @include('layouts.sidebar_prof')
    <form action="" method="post" class="p-form-fluid" enctype="multipart/form-data">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">

        </div>

        <div class="c-imgDrop-container">
            アバター画像
            <label class="c-area-drop c-avatar js-area-drop">
              <input type="file" name="avatar" value="" class="c-input-file js-input-file">
              <img src="{{ isset($dbUserData->avatar) ? $dbUserData->avatar : '' }}" alt="" class="c-prev-img js-prev-img">
              ドラッグ＆ドロップ
            </label>
          </div>
        <div class="p-form-area-msg">
          {{ $errors->first('avatar') }}
        </div>

        <label for="" class="p-form-group">
          名前
          <input type="text" name="name" value="{{ old('name', $dbUserData->name) }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('name') }}
        </div>

        <label for="" class="p-form-group">
          メールアドレス
          <input type="text" name="email" value="{{ old('email', $dbUserData->email) }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('email') }}
        </div>

        <label class="p-form-group">
          自己紹介
          <textarea name="profile" id="" cols="30" rows="10" class="p-form-control p-form-textarea js-count-val">{{ old('profile', $dbUserData->profile) }}</textarea>
        </label>
        <p><span class="js-count-show">0</span>/500</p>
        <div class="p-form-area-msg">
          {{ $errors->first('profile') }}
        </div>

        <button type="submit" value="送信" class="c-btn-submit">送信</button>
      </div>
      {{ csrf_field() }}
    </form>

    @include('layouts.sidebar_menu')
    </div>
  </div>

@endsection