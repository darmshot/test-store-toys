<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    @vite
</head>
<body class="antialiased">
{{--<div class="media-test"></div>--}}

<header>
    <div class="container">
       <div class="bg-dark" style="height: 90px"></div>
    </div>
</header>
<a href="{{route('home')}}">home</a>
<a href="{{route('about')}}">about</a>
<a href="{{route('catalog.category',['category_id'=>1])}}">category 1</a>
<a href="{{route('catalog.product',['product_id'=>1])}}">product 1</a>
<div id="app">
    @yield('body')
</div>
</body>
</html>
