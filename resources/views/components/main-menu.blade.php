<div class="d-none">
    <nav id="my-menu">
        <ul>
            <li><span>Каталог</span>
                <ul>
                    @foreach($categories as $category)
                        @include('parts.menu-item',['item'=>$category])
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="{{url('kontakty')}}">Контакты</a>
            </li>
        </ul>
    </nav>
</div>
