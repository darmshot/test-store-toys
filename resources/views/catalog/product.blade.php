@extends('app')
@section('body_id','catalog-product')
@section('body')
    <div class="catalog-product-wrapper space-10">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <product-gallery product-id="{{$product->id}}"></product-gallery>
                </div>
                <div class="col-1 d-none d-lg-block"></div>
                <div class="col-12 col-md-6 col-lg-5 catalog-product-col-description">
                    {!! $product->getStockStatus() !!}
                    <div class="catalog-product-space-10"></div>
                    <h1 class="page-title">{{$product->title}}</h1>
                    <div>
                        <span class="catalog-product-label">Артикул:</span><span class="catalog-product-label-value">{{$product->sku}}</span>
                    </div>

                    @if($product->price_special)
                        <span class="price price--old">
                                    {!! $product->getPrice() !!}
                                </span>
                        <span class="price-percent ms-2 me-3">{{ $product->getPriceSpecialPercent() }}</span>
                        <span class="price price--xl price--special">{!! $product->getPriceSpecial() !!}</span>
                    @else
                        <span class="price price--xl">
                                    {!! $product->getPrice() !!}
                                </span>
                    @endif

                    <div class="catalog-product-space-20"></div>
                    <el-button @click="{!! '$store.dispatch(\'common/handleAddProductToCart\',{product_id:'.$product->id.'} )' !!}" class="el-button--size-44-1 el-button--orange-1-up catalog-product-btn-buy">
                        Купить
                    </el-button>
                    <div class="catalog-product-space-20"></div>
                    <div class="catalog-product-w-fix">
                        <ul class="list-unstyled list-underline">
                            @foreach($product->productAttributes as $attribute)
                                <li>
                                    <span class="list-underline__label">{{$attribute->title}}</span>
                                    <span class="list-underline__value">{{$attribute->value}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="catalog-product-description">
                        {!! $product->getDescription() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <products class="space-10" title="Возможно вам понравится" type="related" :params="{product_id:{{$product->id}}}"></products>
    </div>
@endsection




