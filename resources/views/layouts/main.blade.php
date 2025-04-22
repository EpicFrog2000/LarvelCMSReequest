<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Domyślny tytuł')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    @if(session('_auth'))
        @vite(['resources/js/admin/main.js'])
        @include('partials.adminMenu')
    @endif
</head>
<body>
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
