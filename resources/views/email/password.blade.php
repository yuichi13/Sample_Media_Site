<a href="{{ config('app.url') }}">{{ config('app.name') }}</a><br>
<br>
パスワードをリセットします。以下のリンクをクリックしてください。<br>
このメールに心当たりのない場合は、無視してください。
<p>
    {{ $actionText }}: <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
</p>