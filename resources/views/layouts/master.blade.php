<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="{{ asset('manifest.json') }}?v={{config('app.version', '1')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <link rel="icon" href="{{ asset('/img/logo-app.svg') }}" type="image/svg+xml">
    {{-- <link rel="shortcut-icon" href="{{ asset('/img/logo-app.svg') }}" type="image/svg+xml"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v={{config('app.version', '1')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}?v={{config('app.version', '1')}}" defer></script>


    {{-- <link rel="icon" type="image/png" href="{{ url('/images/logo-app-16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ url('/images/logo-app-32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ url('/images/logo-app-64.png') }}" sizes="64x64">
    <link rel="icon" type="image/png" href="{{ url('/images/logo-app-128.png') }}" sizes="128x128">

    <meta name="description" content="{{ config('app.descrip') }}"/>

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ config('app.name') }}" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:image" content="{{ url('/images/logo-app-256.png') }}" />
    <meta property="og:description" content="{{ config('app.descrip') }}" /> --}}
</head>
{{-- <body> --}}
<body>
    <div id="app">
        @yield('content')
    </div>

</body>
</html>