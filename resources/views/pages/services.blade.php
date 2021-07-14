@extends('app')
@section('body_id','page-services')
@section('body')
    <div class="container">
        <h1 class="page-title space-10">{{$page->title}}</h1>
       <div>
           {!! $page->content !!}
       </div>
    </div>
@endsection
