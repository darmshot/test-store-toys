@extends('app')
@section('body_id','catalog-category')
@section('body')
    <div class="container">
        <h1 class="page-title">{{$category->title}}</h1>
        <catalog-product v-loading="$store.state.catalog.loadingPage"></catalog-product>
    </div>
@endsection
