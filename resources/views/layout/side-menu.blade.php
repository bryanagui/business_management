@extends('../layout/main')

@section('head')
@yield('subhead')
@endsection

@section('content')
@include('../layout/components/mobile-menu')
<div class="flex">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="" class="intro-x flex items-center pl-5 pt-4">
            <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
            <span class="hidden xl:block text-white text-lg ml-3">
                Rubick
            </span>
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            @foreach ($side_menu as $menuKey => $menu)
            @if($menu['title'] == 'Staff' || $menu['title'] == 'Room Management' || $menu['title'] == "Inventory Management")
            @role('Administrator|Twice')
            {!! $menu['title'] == 'Staff' ? '<div class="side-nav__devider my-6"></div>' : null !!}
            <li>
                <a href="{{ isset($menu['route_name']) ? route($menu['route_name']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon">
                        <i data-feather="{{ $menu['icon'] }}"></i>
                    </div>
                    <div class="side-menu__title">
                        {{ $menu['title'] }}
                        @if (isset($menu['sub_menu']))
                        <div class="side-menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                            <i data-feather="chevron-down"></i>
                        </div>
                        @endif
                    </div>
                </a>
            </li>
            @endrole()
            @else
            <li>
                <a href="{{ isset($menu['route_name']) ? route($menu['route_name']) : 'javascript:;' }}" class="{{ $first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                    <div class="side-menu__icon">
                        <i data-feather="{{ $menu['icon'] }}"></i>
                    </div>
                    <div class="side-menu__title">
                        {{ $menu['title'] }}
                        @if (isset($menu['sub_menu']))
                        <div class="side-menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                            <i data-feather="chevron-down"></i>
                        </div>
                        @endif
                    </div>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </nav>
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        @include('../layout/components/top-bar')
        @yield('subcontent')
    </div>
    <!-- END: Content -->
</div>
@endsection
