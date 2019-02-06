@extends('administration')

@section('title', 'Správa súčiastok')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Správa autodielov </h2>
        <hr class="blackHR">
    </div>
    <div class="small-box" style="margin-bottom: 5%">
        {{ Form::open(array('url' => 'administration/administrate-car-parts/addCarBrand', 'id' => 'submit-add-car-brand')) }}
        <h3>Pridaj značku auta:</h3>
        <hr class="blackHR">
        {!! Form::label('car_brand', 'Značka auta:') !!}
        {!! Form::text('car_brand', $value = null, ['class' => 'form-control', 'required']); !!}
        <div class="alert alert-danger error-add-car-brand-div" role="alert">
            <p id="error-add-car-brand-msg"></p>
        </div>
        <div class="text-center ">
            <button id="button-add-car-brand" type="button" class="btn btn-warning btn-lg submit-div-button">Pridaj značku auta</button>
        </div>
        {{ Form::close() }}
    </div>

    <div class="small-box" style="margin-bottom: 5%">
        {{ Form::open(array('url' => 'administration/administrate-car-parts/addCarType', 'id' => 'submit-add-car-type')) }}
        <h3>Pridaj model auta:</h3>
        <hr class="blackHR">
        <div class="form-group">
            {!! Form::Label('car_brand_all', 'Prosím vyberte si značku auta:') !!}
            {!! Form::select('car_brand_select', $car_brands, null, ['class' => 'form-control', 'id' => 'car_brand_all', 'placeholder' => 'Vyberte značku auta...']) !!}
        </div>
        {!! Form::label('car_type_add', 'Model auta:') !!}
        {!! Form::text('car_type_add', $value = null, ['class' => 'form-control', 'required']); !!}
        <div class="alert alert-danger error-add-car-type-div" role="alert">
            <p id="error-add-car-type-msg"></p>
        </div>
        <div class="text-center ">
            <button id="button-add-car-type" type="button" class="btn btn-warning btn-lg submit-div-button">Pridaj model auta</button>
        </div>
        {{ Form::close() }}
    </div>

    <div class="small-box" style="margin-bottom: 5%">
        {{ Form::open(array('url' => 'administration/administrate-car-parts/addCarPart', 'id' => 'submit-add-car-part' , 'files' => true)) }}
        <h3>Pridaj autosúčiastku:</h3>
        <hr class="blackHR">
        {!! Form::Label('car_brand_parts', 'Značka auta:') !!}
        {!! Form::select('car_brand_parts', $car_brands, null, ['class' => 'form-control', 'id' => 'car_brand_parts', 'placeholder' => 'Vyberte značku auta...']) !!}

        <div id="car_type_parts_div">
            {!! Form::Label('car_type_parts', 'Model auta:') !!}
            {!! Form::select('car_type_parts',$car_type ,null, ['class' => 'form-control', 'id' => 'car_type_parts']) !!}
        </div>

        {!! Form::label('car_part_name', 'Názov autosúčiastky:') !!}
        {!! Form::text('car_part_name', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('part_price', 'Cena autosúčiastky:') !!}
        <div class="hours-box">
            {!! Form::number('part_price',null, array('class'=>'form-control' , 'required', 'step' => '0.01')) !!}
        </div>

        {!! Form::label('stock', 'Počet KS na sklade:') !!}
        <div class="hours-box">
            {!! Form::number('stock',null, array('class'=>'form-control' , 'required')) !!}
        </div>

        {!! Form::label('image', 'Vložte obrázok k autosúčiastke:') !!}
        <div class="hours-box">
            {!! Form::file('image') !!}
        </div>

        <div class="alert alert-danger error-add-car-parts-div" role="alert">
            <p id="error-add-car-parts-msg"></p>
        </div>
        <div class="text-center ">
            <button id="button-add-car-parts" type="button" class="btn btn-warning btn-lg submit-div-button">Pridaj autosúčiastku</button>
        </div>

        {{ Form::close() }}
    </div>



@endsection