@extends('layouts.master')
@section('title', '記事投稿ページ')
@section('content')

  <div class="c-container-fluid">
    <h2 class="c-container__title">{{ (isset($post)) ? '記事編集' : '新規記事投稿'}}</h2>
    <div id="container-2column">
    
    <main class="c-main" id="main">
    <form action="{{ (isset($post)) ? route('user.post_edit', [$post->id]) : route('user.post_article') }}" method="post" class="p-form-fluid" enctype="multipart/form-data">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">

        </div>

        <div class="c-imgDrop-container">
            記事トップ画像
            <label class="c-area-drop js-area-drop">
              <input type="file" name="pic" value="" class="c-input-file js-input-file">
              <img src="{{ (isset($post->pic)) ? $post->pic : '' }}" alt="" class="c-prev-img js-prev-img">
              ドラッグ＆ドロップ
            </label>
          </div>
        <div class="p-form-area-msg">
          {{ $errors->first('avatar') }}
        </div>

        <label for="" class="p-form-group">
          タイトル
          <input type="text" name="title" value="{{ old('title', (isset($post)) ? $post->title : '' ) }}" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('title') }}
        </div>

        <label class="p-form-group">
          本文
          <textarea name="content" id="" cols="30" rows="10" class="p-form-control p-form-textarea js-count-val">{{ old('content', (isset($post)) ? $post->content : '') }}</textarea>
        </label>
        <p class="js-count-num"><span class="js-count-show">0</span>/<span class="js-count-limit">500</span></p>
        <div class="p-form-area-msg">
          {{ $errors->first('content') }}
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