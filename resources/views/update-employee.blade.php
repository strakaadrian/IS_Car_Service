@extends('administration')

@section('title', 'Aktualizuj zamestnanca')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Vitajte v menu pre aktulizáciu zamestnanca. </h2>
        <hr class="blackHR">
    </div>

    <div class="medium-box">
        {!! Form::Label('update-rc', 'Vyberte si zamestnanca:') !!}
        <select class="form-control" name="rc" id="update-rc">
            <option value="">Vyberte si zamestnanca...</option>
            @foreach($employees as $employee)
                <option  value="{{$employee->identification_no}}">{{ $employee->identification_no }} - {{ $employee->first_name  }} {{ $employee->last_name  }}</option>
            @endforeach
        </select>
    </div>

    {{ Form::open(array('url' => 'administration/add-employee/new-employee', 'id' => 'new-employee-id')) }}
    <div class="form-group medium-box update-emp">
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

        {!! Form::label('name', 'Meno:') !!}
        {!! Form::text('name', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('surname', 'Priezvisko:') !!}
        {!! Form::text('surname', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('street', 'Ulica:') !!}
        {!! Form::text('street', $value = null, ['class' => 'form-control', 'required']); !!}

        {!! Form::label('orientation_no', 'Č. domu:') !!}
        {!! Form::number('orientation_no', $value = null, ['class' => 'form-control', 'required']); !!}

        <br>
        <p>Firemné údaje.</p>
        <hr class="blackHR">

        <div class="small-box">
            {!! Form::label('position', 'Pracovná pozícia:') !!}
            {!! Form::select('position', array( 'administrativa' => 'administrativa' , 'mechanik' => 'mechanik' , 'elektrotechnik' => 'elektrotechnik', 'karosar' => 'karosar', 'lakyrnik' => 'lakyrnik'), null, array('class'=>'form-control' , 'required')) !!}
        </div>

        {!! Form::label('hour_start', 'Hodina, nástupu do práce:') !!}
        <div class="hours-box">
            {!! Form::select('hour_start', array( 7 => 7 , 8 => 8 , 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17), null, array('class'=>'form-control' , 'required')) !!}
        </div>

        {!! Form::label('hour_end', 'Hodina, ukončenia práce:') !!}
        <div class="hours-box">
            {!! Form::select('hour_end', array( 7 => 7 , 8 => 8 , 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17), null, array('class'=>'form-control' , 'required')) !!}
        </div>

        {!! Form::label('price_per_hour', 'Cena práce za hodinu:') !!}
        <div class="hours-box">
            {!! Form::number('price_per_hour',null, array('class'=>'form-control' , 'required')) !!}
        </div>

        <div class="alert alert-danger error-new-emp-div" role="alert">
            <p id="error-new-emp-msg"></p>
        </div>
        <div class="text-center new-emp-submit ">
            <button id="submit-new-emp-button" type="button" class="btn btn-warning btn-lg">Odošli formulár</button>
        </div>
    </div>
    {{ Form::close() }}
@endsection