@extends('layouts.master')
@section('title', 'お問い合わせ')
@section('content')

  <div class="c-container-fluid">
    <h2 class="c-container__title">お問い合わせ</h2>
    <div id="container-2column">
    <main id="main">
    <form action="" method="post" class="p-form-fluid">
      <div class="p-form-wrapper">
        <div class="p-form-area-msg">

        </div>

        <label for="" class="p-form-group">
          件名
          <input type="text" name="subject" class="p-form-control">
        </label>
        <div class="p-form-area-msg">
          {{ $errors->first('subject') }}
        </div>

        <label class="p-form-group">
          内容
          <textarea name="content" id="" cols="30" rows="10" class="p-form-control p-form-textarea"></textarea>
        </label>
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
  