@extends('layouts.admin_master')
@section('title', '管理者用記事詳細ページ')
@section('content')

  <div class="c-container">
    <div class="p-post">
      <div class="p-post__header">
        <div class="p-post__date">{{ $post->created_at->format('Y年 m月d日') }}</div>
        <div class="p-post__author">{{ $post->user->userName() }}</div>
        <div class="p-post__edit-btns">
          <a href="{{ route('admin.post_delete', [$post->id]) }}" class="c-edit-btn c-edit-btn__delete js-btn-del" data-message="本当に削除しますか？">削除</a>
        </div>
      </div>
      <h2 class="p-post__title">{{ $post->title }}</h2>
      <div class="p-post__thum">
        <img src="{{ $post->pic() }}" alt="" class="p-post__img">
      </div>
      <p class="p-post__content">
        {{ $post->content }}
      </p>
    </div>
    <a href="{{ url()->previous('home') }}">&laquo; 記事一覧に戻る</a>
  </div>

  @endsection
