@extends('administration')

@section('title', 'Ukonči p. pomer')

@section('admin-content')
    <div>
        <div class="sectionHeader">
            <h2 class="text-center"> Vitajte v menu pre ukončenie pracovného pomeru so zamestnancom </h2>
            <hr class="blackHR">
        </div>

        {{ Form::open(array('url' => 'administration/terminate-employee/terminate', 'id' => 'terminate-employee-id')) }}
        <div class="medium-box">
            <p> Po skončení pomeru bude zamestanenc stále evidovaný v systéme. </p>

            {!! Form::Label('rc', 'Vyberte si zamestnanca:') !!}
            <select class="form-control" name="rc" id="rc">
                @foreach($employees as $employee)
                    <option  value="{{$employee->identification_no}}">{{ $employee->identification_no }} - {{ $employee->first_name  }} {{ $employee->last_name  }}</option>
                @endforeach
            </select>

            {!! Form::label('termination_date', 'Dátum ukončenia pracovného pomeru:') !!}
            <div class="hours-box">
                {!! Form::date('termination_date',null, array('class'=>'form-control hours-box', 'required')) !!}
            </div>

            <div class="text-center terminate-emp-submit ">
                <button id="submit-terminate-emp-button" type="submit" class="btn btn-warning btn-lg">Odošli formulár</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection
