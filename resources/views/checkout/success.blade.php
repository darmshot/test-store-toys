@extends('app')
@section('body_id','checkout-success')
@section('body')
    <div class="container">
        <div class="container space-10">
            <h1 class="page-title">{{$page->title}}</h1>
        </div>

        <p>
            Спасибо за заказ. Ваш заказ обрабатывается в ближайшее время наш менеджер свяжется с вами
        </p>
    </div>
@endsection




