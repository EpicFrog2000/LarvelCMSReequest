@extends('layouts.main')

@section('title', 'Strona główna')

@section('content')



    <wyswigPanel>
        <h1 class='wyswig'>To jest strona główna</h1>
    </wyswigPanel>

    <p>Treść strony.</p>

    @include('partials.slider')



@endsection
