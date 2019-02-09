@extends('administration')

@section('title', 'Najlepšie mesačné zárobky')

@section('admin-content')

    <div class="sectionHeader">
        <h2 class="text-center"> Graf zarobených financii firiem v aktuálny mesiac </h2>
        <hr class="blackHR">
    </div>

    <div class="container-fluid graph-div">
        {!! $chart->container()  !!}
        {!! $chart->script() !!}
    </div>

@endsection