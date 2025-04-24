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



@foreach ($Containers_Data as $containerName => $container)
    <div class="container" data-id="{{ $container['id'] }}">
        <h3>Container: {{ $containerName }}</h3>
        <p>Order: {{ $container['order'] }}</p>
        <div class="template">
            {!! $container['template'] !!}
        </div>
        @if (!empty($container['children']))
            <div class="children">
                <h4>Children:</h4>
                <ul>
                    @foreach ($container['children'] as $child)
                        <li>
                            <strong>ID:</strong> {{ $child->id }} |
                            <strong>Dev name:</strong> {{ $child->dev_name }} |
                            <strong>Type:</strong> {{ $child->type }} |
                            <strong>Values:</strong>
                            @foreach ($child->values as $value)
                            {{ $value }}
                            @endforeach
                            | <strong>Filled Template:</strong> {!! $child->template !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p>No children.</p>
        @endif
    </div>
    <hr>
@endforeach


testowy w templejcie:
<wyswigElement id='testowy'>
    @if(!empty($Element_Structure_variables['testowy']))
        @foreach($Element_Structure_variables['testowy'] as $element)
            {!! $element['value'] !!}
        @endforeach
    @endif

</wyswigElement>



@include('partials.slider')

@endsection