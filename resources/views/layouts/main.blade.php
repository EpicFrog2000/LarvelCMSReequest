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
                let StartValues = @json($Containers_Data);
                let view_name = @json(Route::currentRouteName());
                //console.log(StartValues);
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

