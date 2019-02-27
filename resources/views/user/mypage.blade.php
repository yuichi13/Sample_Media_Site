@extends('layouts.master')
@section('title', 'マイページ')
@section('content')


  <div class="c-container-fluid">
    <div id="container-3column">
    @include('layouts.sidebar_prof')

    <main class="c-main" id="main">
      @if(($dbPostData->first()) === null) <div style="width:600px;text-align:center;margin-top:100px;">記事がありません</div> @endif
      @foreach($dbPostData->all() as $post)
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
      <div class="pagination-wrapper">{{ $dbPostData->links() }}</div>
    </main>

    @include('layouts.sidebar_menu')
    </div>
  </div>


@endsection
