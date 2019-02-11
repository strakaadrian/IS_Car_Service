@extends('Administration/administration')

@section('title', 'Správa služieb')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Spravovanie služieb </h2>
        <hr class="blackHR">
    </div>
    <div class="admin-services admin-watch-parts">
        <table class="table ">
            <thead class="service-table-head">
            <tr>
                <th class="text-center" scope="col">#ID</th>
                <th class="text-center" scope="col">Názov</th>
                <th class="text-center" scope="col">Hod. práce</th>
                <th class="text-center" scope="col">Cena / hod</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr class="car_part_ok">
                    <td class="text-center service-row "> {{ $service->service_id }}</td>
                    <td class="text-center service-row "> {{ $service->name }}</td>
                    <td class="text-center service-row "> {{ $service->hour_duration }}</td>
                    <td class="text-center service-row "> {{ $service->price_per_hour }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="small-box" style="margin-bottom: 5%">
        {{ Form::open(array('url' => 'administration/admin-services/updateServices')) }}
        <h3> Uprav službu:</h3>
        <hr class="blackHR">
        {!! Form::Label('service_update_id', 'ID služby:') !!}
        <select class="form-control service_update" name="service_update" id="service_update_id">
            <option value="" hidden disabled selected>Vyberte si ID služby...</option>
            @foreach($services as $service)
                <option  value="{{$service->service_id}}">{{$service->service_id}}</option>
            @endforeach
        </select>
        {!! Form::label('hour_duration', 'Hodín práce:') !!}
        <div class="hours-box">
            {!! Form::number('hour_duration', $value = null, ['class' => 'form-control', 'required','max' => 20, 'min' => 1]) !!}
        </div>
        {!! Form::label('price_per_hour', 'Cena za hodinu práce v €:') !!}
        <div class="hours-box">
            {!! Form::number('price_per_hour', $value = null, ['class' => 'form-control', 'required','max' => 1000, 'min' => 1]) !!}
        </div>
        <div class="text-center ">
            <button type="submit" class="btn btn-warning btn-lg">Aktualizuj službu</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection