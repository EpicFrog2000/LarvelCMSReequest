<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Domyślny tytuł')</title>
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
