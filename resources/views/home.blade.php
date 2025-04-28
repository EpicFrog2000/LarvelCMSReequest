@extends('layouts.main')

@section('title', 'Strona główna')

@section('content')

<wyswigPanel>
    <h1 class='wyswig'>To jest strona główna</h1>
</wyswigPanel>

<p>Treść strony.</p>

@foreach($Site_Settings as $name => $value)
    <li><strong>{{ $name }}:</strong> {{ $value }}</li>
@endforeach

<h3>{{ $Site_Settings['nazwa jakiegoś tam sobie globalnego ustawienia xdd'] ?? 'Brak ustawienia' }}</h3>

<wyswigContainers>
    {!! $Containers_Data['container_1']['filled_template'] !!}



    <!-- inne elementy -->
    <script>
        

        console.log(@json($Containers_Data));


        var AllData = {};
        let wyswigcontainers = document.getElementsByTagName("wyswigcontainers");

        Array.from(wyswigcontainers).forEach((container) => {
            Array.from(container.children).forEach((containerElement) => {
                getData(containerElement);
            });
        });

        function getData(parent) {
            GetContainers(parent);
            GetElements(parent);
        }

        function GetContainers(parent) {
            let childContainers = parent.getElementsByTagName('wyswigContainer');
            if (childContainers.length === 0) return;

            Array.from(childContainers).forEach((container) => {
                //if (!AllData[className]) AllData[className] = [];
                //AllData[container.classList[0]].push({ type: "container" });
                GetContainers(container);
                GetElements(container);
            });
        }

        function GetElements(parent) {
            let childElements = parent.getElementsByTagName('wyswigElement');
            if (childElements.length === 0) return;

            Array.from(childElements).forEach((element) => {
                let variables = Array.from(element.getElementsByTagName('wyswigvariable')).map(variable => variable.innerText);
                let className = element.classList[0];
                if (!AllData[parent.classList[0]]) AllData[parent.classList[0]] = [];

                AllData[parent.classList[0]].push({
                    [element.classList[0]]: variables
                });
            });
        }

        console.log(AllData);

    </script>


</wyswigContainers>
    


@include('partials.slider')

@endsection