<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a></li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon la la-file-o'></i> <span>Pages</span></a>
</li>
<li class='nav-item nav-dropdown'>
    <a class='nav-link nav-dropdown-toggle' href='#'><i class='nav-icon la la-archive'></i> Каталог</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class='nav-link' href='{{ backpack_url('catalog/categories') }}'><i class='nav-icon la la-list'></i>
                Категории</a>
        </li>
        <li class="nav-item">
            <a class='nav-link' href='{{ backpack_url('catalog/products') }}'><i class='nav-icon la la-shopping-cart'></i>
                Товары</a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('catalog/manufacturers') }}'><i class='nav-icon la la-list'></i>
                Производители</a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' href='{{ backpack_url('catalog/statuses') }}'><i class='nav-icon la la-tags'></i> Статусы</a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('menu-item') }}"><i class="nav-icon la la-list"></i>
        <span>Меню</span></a></li>

<li class='nav-item'><
    a class='nav-link' href='{{ backpack_url('alias') }}'><i class='nav-icon la la-link'></i> Aliases</a>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i>
        <span>Settings</span></a>
</li>
<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i>
        Logs</a>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('attribute') }}'><i class='nav-icon la la-question'></i> Attributes</a></li>