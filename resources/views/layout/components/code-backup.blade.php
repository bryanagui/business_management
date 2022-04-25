<!-- Side Menu after whole <a> tag sa else statement -->
@if (isset($menu['sub_menu']))
<ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
    @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
    <li>
        <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}" class="{{ $second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
            <div class="side-menu__icon">
                <i data-feather="activity"></i>
            </div>
            <div class="side-menu__title">
                {{ $subMenu['title'] }}
                @if (isset($subMenu['sub_menu']))
                <div class="side-menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                    <i data-feather="chevron-down"></i>
                </div>
                @endif
            </div>
        </a>
        @if (isset($subMenu['sub_menu']))
        <ul class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
            @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
            <li>
                <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}" class="{{ $third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon">
                        <i data-feather="zap"></i>
                    </div>
                    <div class="side-menu__title">{{ $lastSubMenu['title'] }}</div>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach
</ul>
@endif
<!-- End: Side Menu after whole <a> tag sa else statement -->
