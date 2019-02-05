@extends('administration')

@section('title', 'Pridaj službu')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Pridaj službu </h2>
        <hr class="blackHR">
    </div>
    <div class="add-service" style="margin-bottom: 5%">
        {{ Form::open(array('url' => 'administration/admin-services/addNewService')) }}

        {!! Form::label('service_name', 'Názov servisu:') !!}
        {!! Form::text('service_name', $value = null, ['class' => 'form-control', 'required']); !!}

        <div style="margin-right: 50%">
            {!! Form::label('service_type', 'Typ servisu:') !!}
            {!! Form::select('service_type', array('mechanik' => 'Mechanik', 'elektrotechnik' => 'Elektrotechnik', 'karosar' => 'Karosar', 'lakyrnik' => 'Lakyrnik'),  null, array('class'=>'form-control')) !!}
        </div>

       {!! Form::label('hour_duration', 'Hodín práce:') !!}
        <div class="hours-box">
            {!! Form::number('hour_duration', $value = null, ['class' => 'form-control', 'required','max' => 20, 'min' => 1]) !!}
        </div>
        {!! Form::label('price_per_hour', 'Cena za hodinu práce v €:') !!}
        <div class="hours-box">
            {!! Form::number('price_per_hour', $value = null, ['class' => 'form-control', 'required','max' => 1000, 'min' => 1]) !!}
        </div>
        <div class="text-center ">
            <button type="button" class="btn btn-warning btn-lg add-new-service-button">Pridaj službu</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection

