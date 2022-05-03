<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="utf-8">
    <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
    <title>Error 404: Not Found</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
</head>

<body class="py-5">
    <div class="container">
        <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
            <div class="-intro-x lg:mr-20">
                <img alt="Rubick Tailwind HTML Admin Template" class="h-48 lg:h-auto" src="{{ asset('dist/images/error-illustration.svg') }}">
            </div>
            <div class="text-white mt-10 lg:mt-0">
                <div class="intro-x text-8xl font-medium">404</div>
                <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. This page has gone missing.</div>
                <div class="intro-x text-lg mt-3">You may have mistyped the address or the page may have moved.</div>
                <a href="{{ route('dashboard') }}" class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Back to Home</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('dist/js/app.js') }}"></script>
</body>

</html>
