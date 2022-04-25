<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $dark_mode ? 'dark' : '' }}{{ $color_scheme != 'default' ? ' ' . $color_scheme : '' }}">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('head')
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}" />
    <!-- END: CSS Assets-->

    <!-- BEGIN: Fontawesome -->
    <script src="https://kit.fontawesome.com/0f950bae5c.js" crossorigin="anonymous"></script>
    <!-- END: Fontawesome -->
</head>
<!-- END: Head -->

@yield('body')

</html>
