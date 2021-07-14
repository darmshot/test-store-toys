@extends('app')
@section('body_id','page-home')
@section('body')
    @php
        $main_slider = [];
        $main_slider[] = [
            'image'        => vite_asset('images/banner-2.jpg'),
            'image_mobile' => '',
            'title'        => '',
            'class'        => '',
            'description' => '

                               <div class="display-4 text-white mb-4">
                                   Игрушки всех возрастов
                                </div>
                                <a class="el-button el-button--size-44-1 el-button--orange-1" href="https://hypevenom.by/shop/">
               перейти в каталог
             </a>',

        ];
        /*
       $main_slider[] = [
            'image'        => vite_asset('images/slide-new-1.jpg'),
            'image_mobile' => '',
            'title'        => '',
            'class'        => 'main-slider-content--position-bottom',
            'description' => '
        <div class="h4 text-white">время изменилось</div>
        <div class="display-4 text-white mb-4">
                                  будущее уже наступило
                                </div>
                                 <a class="c-btn c-btn--main-slider c-btn--primary" href="https://hypevenom.by/shop/">
                перейти в каталог
              </a>',
        ]
*/
    @endphp

    <main-slider class="space-10" :sliders='@json($main_slider)'></main-slider>
    <div class="container">
        <x-app::choose-age></x-app::choose-age>
        <x-app::top-categories :ids="[8]"></x-app::top-categories>
        <products class="space-10" title="Популярные игрушки" type="ids" :params="{ids:@json(array(106,102)??[])}"></products>
        <div class="description">
            Желаете купить игрушки в Минске? Наш интернет-магазин детских игрушек toys.by готов предложи все. Не
            знаете что подарить ребенку, когда ,вас, позвали в гости? Простое решение - подарочный сертификат !
            Ломаете голову над тем, чем порадовать малыша и как подарить ему настоящий праздник? Вспоминаете себя в
            ранние годы? Что ,вам, больше всего нравилось? О чем ,вы, мечтали? Может быть, это конструктор или
            кукла? Или почти настоящие авто ? А может это интерактивный питомец? В нашем магазине можно купить
            детские игрушки, которые действительно удивят вашего малыша: огромный каталог с фото, выгодные цены,
            постоянное обновление ассортимента.
        </div>
    </div>
@endsection
