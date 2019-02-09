@extends('administration')

@section('title', 'Graf rezervácii')

@section('admin-content')

    <div class="sectionHeader">
        <h2 class="text-center"> Graf počtu rezervácii na najbližší týžden </h2>
        <hr class="blackHR">
    </div>

    <div class="container-fluid graph-div">
        {!! $chart->container()  !!}
        {!! $chart->script() !!}
    </div>

@endsection