<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <meta property="fb:app_id" content="3034978530121884" />
    <meta property="og:image" content="https://test-blog.almost-digital.com/storage/images/flower.jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="1200" />
    <meta property="og:url" content="https://test-blog.almost-digital.com" />
    <meta property="og:title" content="test" />
    <meta property="og:description" content="test" />
    <meta property="og:type" content="article" />

    <title>{{env('APP_NAME')}}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body>

<div id="app">
</div>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
