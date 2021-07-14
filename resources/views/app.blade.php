<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @foreach(Document::getMetas() as $name => $content)
        <meta name="{{$name}}" content="{{$content}}">
    @endforeach
    <title>{{Document::getMetaTitle()}}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <style>
        [v-cloak] > * {
            display: none!important;
        }
        .d-none {
            display: none!important;
        }
    </style>
    <script type="text/javascript">
        var vars = {!! Document::getScriptVars() !!}
    </script>
    @vite
</head>
<body>
<div id="app" v-cloak>
    <header class="header" :class="headerClass">
        <div class="row g-0 header__row-content">
            <div class="col-auto header__col-start">
                <div class="header__content-wrapper">
                    <div class="header__content-wrapper-col">
                        <the-hamburger></the-hamburger>
                    </div>
                    <div class="header__content-wrapper-col">
                        <div class="header__logo">
                            @if(Functions::isFrontPage())
                                <span>
                                <img src="{{vite_asset('images/logo.png')}}" alt="logo">
                            </span>
                            @else
                                <a href="{{route('home')}}">
                                    <img src="{{vite_asset('images/logo.png')}}" alt="logo">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col header__col-search d-none d-xl-block">
                <search></search>
            </div>
            <div class="col-auto header__col-end ms-auto">
                <div class="header__content-wrapper header__content-wrapper--end">
                    <div class="header__content-wrapper-col header__content-wrapper-col--move-end d-xl-none">
                        <button @click="handleSearchBtn()" class="header-search-btn">
                            <i class="el-icon-search header-search-btn__icon"></i>
                        </button>
                    </div>
                    <div class="header__content-wrapper-col header__content-wrapper-col--move-end">
                        <div class="header-phone">
                            <div class="header-phone__wrapper">
                                <svg width="18" height="18" class="header-phone__svg-label" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor" d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z" class=""></path>
                                </svg>
                                <a class="header-phone__link" href="{{Functions::telLink('+ 375 (29) 679 53 36')}}">
                                    <svg width="24" height="24" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="d-xl-none">
                                        <path fill="currentColor" d="M497.39 361.8l-112-48a24 24 0 0 0-28 6.9l-49.6 60.6A370.66 370.66 0 0 1 130.6 204.11l60.6-49.6a23.94 23.94 0 0 0 6.9-28l-48-112A24.16 24.16 0 0 0 122.6.61l-104 24A24 24 0 0 0 0 48c0 256.5 207.9 464 464 464a24 24 0 0 0 23.4-18.6l24-104a24.29 24.29 0 0 0-14.01-27.6z" class=""></path>
                                    </svg>
                                    <span class="d-none d-xl-inline-block">+ 375 (29) 679 53 36</span>
                                </a>
                            </div>

                        </div>

                    </div>
                    <div class="header__content-wrapper-col">
                        <cart-dropdown></cart-dropdown>
                    </div>
                </div>

            </div>
        </div>

        <div class="header__search-dropdown d-xl-none">
            <search></search>
        </div>

    </header>
{{--    <div class="media-test">--}}
{{--        <div class="media-test__point d-none d-xxl-block">XXL</div>--}}
{{--        <div class="media-test__point d-none d-xl-block d-xxl-none">XL</div>--}}
{{--        <div class="media-test__point d-none d-lg-block d-xl-none">LG</div>--}}
{{--        <div class="media-test__point d-none d-md-block d-lg-none">MD</div>--}}
{{--        <div class="media-test__point d-none d-sm-block d-md-none">SM</div>--}}
{{--        <div class="media-test__point d-sm-none">XS</div>--}}
{{--    </div>--}}



    <div id="@yield('body_id')" class="content {{Functions::isFrontPage()?'':'content--pt'}}  content-body">
{{--        @if(Functions::isFrontPage() === false)--}}
{{--            <div class="container">--}}
{{--                <el-breadcrumb class="el-breadcrumb--page" separator-class="el-icon-arrow-right">--}}
{{--                    <el-breadcrumb-item class="el-breadcrumb-item--page"><a href="#">Главная</a></el-breadcrumb-item>--}}
{{--                    <el-breadcrumb-item class="el-breadcrumb-item--page"><a href="#">sub category</a></el-breadcrumb-item>--}}
{{--                    <el-breadcrumb-item class="el-breadcrumb-item--page"><a href="#">promotion list</a></el-breadcrumb-item>--}}
{{--                    <el-breadcrumb-item class="el-breadcrumb-item--page">promotion detail</el-breadcrumb-item>--}}
{{--                </el-breadcrumb>--}}
{{--            </div>--}}
{{--        @endif--}}

        @yield('body')
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <img src="{{vite_asset('images/logo.png')}}" alt="logo">
                </div>
                <div class="col-sm-4">
                    <div class="h4 text-uppercase">Информация</div>
                    <ul class="list-unstyled">
                        <li><a href="{{url('kontakty')}}">Контакты</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <div class="h4 text-uppercase">Связь</div>
                    <ul class="list-unstyled">
                        <li><a href="#">г. Минск ул. Народная 43 оф. 832</a></li>
                        <li>Тел: <a href="{{Functions::telLink('+ 375 (29) 679 53 36')}}">+ 375 (29) 679 53 36</a></li>
                        <li><a href="mailto:herasimenkastanislav@gmail.com">darmshot@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
<x-main-menu></x-main-menu>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
</body>
</html>
