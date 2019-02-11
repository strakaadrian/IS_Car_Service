@extends('Administration/administration')

@section('title', 'Pridaj zákazníka')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Vitajte v menu pre pridanie nového zákazníka. </h2>
        <hr class="blackHR">
    </div>

    {{ Form::open(array('url' => 'administration/add-customer/new-customer', 'id' => 'new-customer-id')) }}
    <div class="form-group medium-box">
        <br>
        <p>Osobné údaje.</p>
        <hr class="blackHR">

        {!! Form::Label('country_id', 'Štát:') !!}
        <select class="form-control" name="country_id" id="country_id">
            @foreach($countries as $country)
                @if($country->country_id == 'SVK')
                    <option selected="selected" value="{{$country->country_id}}">{{$country->country_name}}</option>
                @else
                    <option  value="{{$country->country_id}}">{{$country->country_name}}</option>
                @endif
            @endforeach
        </select>

        {!! Form::label('town', 'Mesto:') !!}
        {!! Form::text('town', $value = null, ['class' => 'form-control', 'required']); !!}
        <div class="small-box">
            {!! Form::label('psc', 'Psč:') !!}
            {!! Form::text('psc', $value = null, ['class' => 'form-control','maxlength' => 5, 'required']); !!}
        </div>

        {!! Form::label('rc', 'Rodné číslo:') !!}
        {!! Form::text('rc', $value = null, ['class' => 'form-control','maxlength' => 11,'minlength' => 11, 'required']); !!}

        {!! Form::label('name', 'Meno:') !!}
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('surname', 'Priezvisko:') !!}
        {!! Form::text('surname', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('street', 'Ulica:') !!}
        {!! Form::text('street', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('orientation_no', 'Č. domu:') !!}
        {!! Form::number('orientation_no', $value = null, ['class' => 'form-control', 'required']); !!}

        <div class="alert alert-danger error error-new-cust-div" role="alert">
            <p id="error-new-cust-msg"></p>
        </div>
        <div class="text-center submit-div-button new-cust-submit ">
            <button id="submit-new-cust-button" type="button" class="btn btn-warning btn-lg">Odošli formulár</button>
        </div>
    </div>


    {{ Form::close() }}

@endsection