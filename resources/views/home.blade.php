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

<wyswigPageData>
    @foreach($Containers_Data as $name => $contenery)
        @foreach($contenery as $nazwaC => $contenerValue)
            {!! $contenerValue['filled_template'] !!}
        @endforeach
    @endforeach
</wyswigPageData>



<!-- inne elementy -->

@include('partials.slider')

@endsection