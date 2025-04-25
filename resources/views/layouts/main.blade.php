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

                //TODO zamiast tego weź elementy z DOM z tagiem wyswigTemplateValue
                var values = @json($Containers_Data);

                console.log(values);

                var view_name = @json(Route::currentRouteName());
                var values_original = @json($Containers_Data);
                console.log(view_name);
                //var new_values_from_site = GetValuesFromTemplate(values, view_name);
                //var original_values_from_site = GetValuesFromTemplate(values_original, view_name);

                // na stronce modyfikujemy sobie dowloli elementy wyswigu
                //new_values_from_site.pop();
                // new_values_from_site[0].jsonvariables[0] = "test";

                // let element = {
                //     jsonvariables: ['test', 'teee'],
                //     dev_name: 'testowy',
                //     view_name: view_name,
                // };
                // new_values_from_site.push(element);

                //TODO on button press zapisz:
                //SaveWyswigChanges(new_values_from_site, original_values_from_site);
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

