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

<wyswigContainer id="container_1">
    {!! $Containers_Data['container_1'] !!}
</wyswigContainer>
    


@include('partials.slider')

@endsection