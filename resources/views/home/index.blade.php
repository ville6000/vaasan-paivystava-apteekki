@extends('layout')

@section('content')
    <p>{{ $monday }} - {{ $sunday }} Vaasan päivystävä apteekki on:</p>
    <h1>{{ $storeName }}</h1>

    <p class="external-links">
        <a href="https://www.vaasa.fi/paivystavat-apteekit">Apteekkien päivystys- ja yhteystiedot</a>
    </p>
@endsection