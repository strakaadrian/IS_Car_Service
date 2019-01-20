@extends('app')

@section('title','Produkty')

@section('content')
    <div class="container products">
        <div class="row">
            {{ Form::open() }}
            <div class="col-md-4 products-form">
                {!! Form::Label('car_brand', 'Značka auta:') !!}
                {!! Form::select('car_brand', $car_brand, null, ['class' => 'form-control', 'id' => 'car_brand', 'placeholder' => 'Vyberte značku auta...']) !!}
            </div>
            <div id="car_type_select" class="col-md-4 products-form">
                {!! Form::Label('car_type', 'Model auta:') !!}
                {!! Form::select('car_type',$car_type ,null, ['class' => 'form-control', 'id' => 'car_type',]) !!}
                <input type="checkbox" class="form-check-input" id="products-check-all">
                <label class="form-check-label" for="products-check-all"> Zobraziť všetky autodiely ? </label>
            </div>
            <div id="car_part_select" class="col-md-4 products-form">
                {!! Form::Label('car_part', 'Náhradný diel:') !!}
                {!! Form::select('car_part', $car_part,  null, ['class' => 'form-control', 'id' => 'car_part', 'placeholder' => 'Vyberte diel...']) !!}
            </div>
            {{ Form::close() }}
         </div>
        <div class="alert alert-danger error-products">
            <strong>Pozor!</strong> <span id="error-products-not-found">  </span>
        </div>
        <div class="text-center customer-submit ">
            <button id="submit-products-button" type="button" class="btn btn-warning btn-lg"> <i class="fa fa-search"></i> Vyhľadaj </button>
        </div>
    </div>

    <div class="container-fluid products-items">

    </div>


@endsection