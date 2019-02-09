@extends('administration')

@section('title', 'Najpredávanejšie súčiastky')

@section('admin-content')

    <div class="sectionHeader">
        <h2 class="text-center"> Graf najpredávanejších súčiastok podľa modelu auta </h2>
        <hr class="blackHR">
    </div>

    <div class="medium-box">
        {{ Form::open(array('action' => 'CarPartsController@getBestSalesGraph'))  }}
        <div class="form-group">
            {!! Form::Label('car_brand_graph', 'Prosím vyberte si značku auta:') !!}
            {!! Form::select('car_brand_graph', $car_brand, null, ['class' => 'form-control', 'id' => 'car_brand_graph', 'placeholder' => 'Vyberte značku auta...']) !!}
        </div>
        <div id="car_type_graph_div">
            {!! Form::label('car_type_graph', 'Model auta:') !!}
            {!! Form::select('car_type_graph', $car_type ,null, ['class' => 'form-control']); !!}

            <div class="text-center customer-submit ">
                <button id="car_parts_graph_button" type="submit" class="btn btn-warning btn-lg"> <i class="fa fa-search"></i> Zobraz graf </button>
            </div>
        </div>

        {{ Form::close() }}
    </div>

    <div class="container-fluid best-car-parts-sales-div">
        @yield('car-parts-graph')
    </div>

@endsection