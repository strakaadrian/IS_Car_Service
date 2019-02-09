
@extends('Administration/Graphs/best-car-parts-sales')

@section('title', 'Najpredávanejšie súčiastky graf')

@section('car-parts-graph')
    {!! $chart->container()  !!}
    {!! $chart->script() !!}
@endsection