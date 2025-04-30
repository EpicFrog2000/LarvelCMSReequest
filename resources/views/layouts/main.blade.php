<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Domyślny tytuł')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    @if(session('_auth'))
        @vite(['resources/js/admin/main.js'])
        @vite(['resources/js/admin/wyswig.js'])
        @include('partials.adminMenu')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let StartValues = @json($Containers_Data);
                let view_name = @json(Route::currentRouteName());
                console.log(StartValues);
                let ModifiedValues = StartValues;
                //TODO zrobić epicką edycje wyswiga


            });
        </script>
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

