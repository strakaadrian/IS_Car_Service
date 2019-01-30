@extends('administration')

@section('title', 'Absencie')

@section('admin-content')
    <div>
        <div class="sectionHeader">
            <h2 class="text-center"> Vitajte v menu pre správu absencii zamestnancov. </h2>
            <hr class="blackHR">
        </div>

        {{ Form::open() }}
        <div class="medium-box">

            {!! Form::Label('rc', 'Vyberte si zamestnanca:') !!}
            <select class="form-control" name="rc" id="rc">
                @foreach($employees as $employee)
                    <option  value="{{$employee->identification_no}}">{{ $employee->identification_no }} - {{ $employee->first_name  }} {{ $employee->last_name  }}</option>
                @endforeach
            </select>
        </div>
        {{ Form::close() }}
    </div>
@endsection
