@extends('administration')

@section('title', 'Graf počtu objednávok')

@section('admin-content')

    <div class="sectionHeader">
        <h2 class="text-center"> Graf počtu objednávok za najbližšie dni. </h2>
        <hr class="blackHR">
    </div>

    <div class="container-fluid graph-div">
        {!! $chart->container()  !!}
        {!! $chart->script() !!}
    </div>

@endsection