<section class="top-categories space-10">
    <div class="h2 title-line">
        <span>@lang('catalog.top_categories.title')</span>
        <span class="title-line__line"></span>
    </div>
    <el-collapse v-if="['xs','sm','md'].includes(breakpoint)" value="0">
    @foreach($categories as $key =>  $category)
            <el-collapse-item class="el-collapse-item--category-top" title="{{$category->title}}" name="{{$key}}">
                <ul class="list-unstyled categories-list">
                @foreach($category->children as $child)
                        <li>
                            <a href="{{$child->url}}">
                                <i class="el-icon-arrow-right categories-list__icon"></i>
                                {{$child->title}}
                            </a>
                        </li>
                @endforeach
                </ul>
            </el-collapse-item>
    @endforeach
    </el-collapse>

    <div class="top-categories__row d-none d-lg-flex">
        @foreach($categories as  $category)
            <div class="top-categories__col">
                <div class="h3"></div>
                <div class="categories-board">
                    <div class="categories-board__title">
                      {{$category->title}}
                    </div>
                    <ul class="list-unstyled categories-board__list">
                        @foreach($category->children as $child)
                            <li class="categories-board__list-item">
                            <span class="categories-board__list-item-icon">
                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.69097 6.39786L2.13604 10.9528C1.91636 11.1725 1.5602 11.1725 1.34054 10.9528L0.809286 10.4215C0.589981 10.2022 0.589559 9.84678 0.808348 9.62696L4.41822 6.0001L0.808348 2.37326C0.589559 2.15344 0.589981 1.79801 0.809286 1.57871L1.34054 1.04745C1.56022 0.82777 1.91638 0.82777 2.13604 1.04745L6.69095 5.60237C6.91063 5.82202 6.91063 6.17818 6.69097 6.39786Z" fill="black"/>
                            </svg>
                            </span>
                                <a href="{{$child->url}}">
                                {{$child->title}}
                            </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach



{{--        @for ($i = 0; $i < 5; $i++)--}}
{{--            <div class="top-categories__col">--}}
{{--                <div class="categories-board">--}}
{{--                    <div class="categories-board__title">--}}
{{--                        Имитационные игры--}}
{{--                    </div>--}}
{{--                    <ul class="list-unstyled categories-board__list">--}}
{{--                        <li class="categories-board__list-item">--}}
{{--                            <span class="categories-board__list-item-icon">--}}
{{--                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M6.69097 6.39786L2.13604 10.9528C1.91636 11.1725 1.5602 11.1725 1.34054 10.9528L0.809286 10.4215C0.589981 10.2022 0.589559 9.84678 0.808348 9.62696L4.41822 6.0001L0.808348 2.37326C0.589559 2.15344 0.589981 1.79801 0.809286 1.57871L1.34054 1.04745C1.56022 0.82777 1.91638 0.82777 2.13604 1.04745L6.69095 5.60237C6.91063 5.82202 6.91063 6.17818 6.69097 6.39786Z" fill="black"/>--}}
{{--                            </svg>--}}
{{--                            </span>--}}
{{--                            <span>--}}
{{--                                                            Фигурки и коллекционные открытки--}}
{{--                            </span>--}}
{{--                        </li>--}}
{{--                        <li class="categories-board__list-item">--}}
{{--                            <span class="categories-board__list-item-icon">--}}
{{--                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M6.69097 6.39786L2.13604 10.9528C1.91636 11.1725 1.5602 11.1725 1.34054 10.9528L0.809286 10.4215C0.589981 10.2022 0.589559 9.84678 0.808348 9.62696L4.41822 6.0001L0.808348 2.37326C0.589559 2.15344 0.589981 1.79801 0.809286 1.57871L1.34054 1.04745C1.56022 0.82777 1.91638 0.82777 2.13604 1.04745L6.69095 5.60237C6.91063 5.82202 6.91063 6.17818 6.69097 6.39786Z" fill="black"/>--}}
{{--                            </svg>--}}
{{--                            </span>--}}
{{--                            <span>--}}
{{--                                                            Воображаемые миры--}}
{{--                            </span>--}}
{{--                        </li>--}}
{{--                        <li class="categories-board__list-item">--}}
{{--                           <span class="categories-board__list-item-icon">--}}
{{--                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M6.69097 6.39786L2.13604 10.9528C1.91636 11.1725 1.5602 11.1725 1.34054 10.9528L0.809286 10.4215C0.589981 10.2022 0.589559 9.84678 0.808348 9.62696L4.41822 6.0001L0.808348 2.37326C0.589559 2.15344 0.589981 1.79801 0.809286 1.57871L1.34054 1.04745C1.56022 0.82777 1.91638 0.82777 2.13604 1.04745L6.69095 5.60237C6.91063 5.82202 6.91063 6.17818 6.69097 6.39786Z" fill="black"/>--}}
{{--                            </svg>--}}
{{--                           </span>--}}
{{--                            <span>--}}
{{--                                                            Как взрослые--}}
{{--                            </span>--}}
{{--                        </li>--}}
{{--                        <li class="categories-board__list-item">--}}
{{--                         <span class="categories-board__list-item-icon">--}}
{{--                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M6.69097 6.39786L2.13604 10.9528C1.91636 11.1725 1.5602 11.1725 1.34054 10.9528L0.809286 10.4215C0.589981 10.2022 0.589559 9.84678 0.808348 9.62696L4.41822 6.0001L0.808348 2.37326C0.589559 2.15344 0.589981 1.79801 0.809286 1.57871L1.34054 1.04745C1.56022 0.82777 1.91638 0.82777 2.13604 1.04745L6.69095 5.60237C6.91063 5.82202 6.91063 6.17818 6.69097 6.39786Z" fill="black"/>--}}
{{--                            </svg>--}}
{{--                         </span>--}}
{{--                            <span>--}}
{{--                                                            Кухня и столовая--}}
{{--                            </span>--}}
{{--                        </li>--}}
{{--                        <li class="categories-board__list-item">--}}
{{--                      <span class="categories-board__list-item-icon items">--}}
{{--                                <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path d="M6.69097 6.39786L2.13604 10.9528C1.91636 11.1725 1.5602 11.1725 1.34054 10.9528L0.809286 10.4215C0.589981 10.2022 0.589559 9.84678 0.808348 9.62696L4.41822 6.0001L0.808348 2.37326C0.589559 2.15344 0.589981 1.79801 0.809286 1.57871L1.34054 1.04745C1.56022 0.82777 1.91638 0.82777 2.13604 1.04745L6.69095 5.60237C6.91063 5.82202 6.91063 6.17818 6.69097 6.39786Z" fill="black"/>--}}
{{--                            </svg>--}}
{{--                      </span>--}}
{{--                            <span>--}}
{{--                                                            DIY - садоводство--}}
{{--                            </span>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endfor--}}
    </div>
</section>
