@extends('layouts.master')
@section('title', 'トップページ')

@section('content')

<div class="c-container-fluid">
  <div id="container-3column">
  
    <main class="c-main" id="main">
      @foreach($posts as $post)
      <a href="{{ url('post-detail', [$post->id]) }}" class="c-card">
        <div class="c-card__thumbnail">
          <img src="{{ $post->pic() }}" alt="" class="c-card__img">
        </div>
        <div class="c-card__body">
          <div class="c-card__header">
            <h3 class="c-card__title">{{ str_limit($post->title, 50) }}</h3>
          </div>
          {{ str_limit($post->content, 40) }}
          <div class="c-card__footer">
            <div class="c-card__author">
              {{ $post->user->userName() }}
            </div>
            <div class="c-card__date">
              {{ $post->created_at->format('Y年 m月d日') }}
            </div>
          </div>
        </div>
      </a><!-- card -->
      @endforeach
      <div class="pagination-wrapper">{{ $posts->links() }}</div>
    </main>
  </div>
</div>
  @endsection
