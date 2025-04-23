@extends('layouts.main')

@section('title', 'Strona główna')

@section('content')

<wyswigPanel>
    <h1 class='wyswig'>To jest strona główna</h1>
</wyswigPanel>

<p>Treść strony.</p>
<wyswigElement id='testowy'>
    @if(!empty($Element_Structure_variables['testowy']))
        @foreach($Element_Structure_variables['testowy'] as $element)
            {!! $element['value'] !!}
        @endforeach
    @endif
</wyswigElement>

@include('partials.slider')

@endsection