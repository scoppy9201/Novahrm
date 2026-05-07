<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('nova-core::app.meta.title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:300,400,500,600,700,800,900" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800;900&display=swap" rel="stylesheet">
    @vite([
        'packages/Nova/Core/src/resources/css/app.css',
        'packages/Nova/Core/src/resources/js/app.js'
    ])
</head>
<body>
    @include('core::partials.navbar')
    @yield('content')
    @include('core::partials.floating')
    @include('core::partials.footer')
    @include('core::components.demo-modal')
</body>
</html>
