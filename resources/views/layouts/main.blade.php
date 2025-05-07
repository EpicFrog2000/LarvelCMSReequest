<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Domyślny tytuł')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    
    @if(session('_auth'))
        @vite(['resources/css/adminElements.css'])
    
        @vite(['resources/js/admin/main.js'])
        @vite(['resources/js/admin/wyswig.js'])


        @include('partials.adminMenu')
        @vite(['resources/js/admin/adminMenu.js'])

        @include('partials.zarzadzaniePlikamiWindow')
        @vite(['resources/js/admin/zarzadzaniePlikamiWindow.js'])

        
        @include('partials.zarzadzaniePlikamiMenu')
        @vite(['resources/js/admin/zarzadzaniePlikamiMenu.js'])

        @include('partials.zmienNazwePlikuForm')
        @vite(entrypoints: ['resources/js/admin/zmienNazwePlikuForm.js'])

                
        <script>

            document.addEventListener('DOMContentLoaded', function () {
                window.StartValues = @json($Containers_Data);
                window.ModifiedValues =  @json($Containers_Data);
                window.view_name = @json(Route::currentRouteName());

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

