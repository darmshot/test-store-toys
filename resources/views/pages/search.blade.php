@extends('app')
@section('body_id','page-search')
@section('body')
    <div class="container">
        <h1 class="page-title">{{$page->title}}</h1>
        <catalog-product v-loading="$store.state.catalog.loadingPage"></catalog-product>
    </div>
@endsection
