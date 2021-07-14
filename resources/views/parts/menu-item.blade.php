<li>
    <a href="{{$item->url}}">{{$item->title}}</a>
    @if($item->children)
        <ul>
            @foreach($item->children as $child)
                @include('parts.menu-item',['item'=>$child])
            @endforeach
        </ul>
    @endif
</li>
