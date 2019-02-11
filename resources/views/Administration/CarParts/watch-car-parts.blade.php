@extends('Administration/administration')

@section('title', 'Množstvo na sklade')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Počet súčiastok na sklade </h2>
        <hr class="blackHR">
    </div>
    <div class="admin-watch-parts">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center" scope="col">#ID</th>
                <th class="text-center" scope="col">Typ</th>
                <th class="text-center" scope="col">Model</th>
                <th class="text-center" scope="col">Súčiastka</th>
                <th class="text-center" scope="col">Na sklade</th>
            </tr>
            </thead>
            <tbody id="car_part_body">
            @foreach($car_parts as $car_part)
                @if($car_part->stock == 0)
                    <tr class="car_part_out">
                @elseif ($car_part->stock > 0 && $car_part->stock < 5)
                    <tr class="car_part_low">
                @else
                    <tr class="car_part_ok">
                @endif
                    <td class="text-center service-row "> {{ $car_part->car_part_id }}</td>
                    <td class="text-center service-row "> {{ $car_part->brand_name }}</td>
                    <td class="text-center service-row "> {{ $car_part->car_type_name }}</td>
                    <td class="text-center service-row "> {{ $car_part->part_name }}</td>
                    <td class="text-center service-row "> {{ $car_part->stock }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="small-box" style="margin-bottom: 5%">
        {{ Form::open(array('url' => 'administration/watch-car-parts/updateCarParts')) }}
        <h3>Aktualizuj množstvo na sklade:</h3>
        <hr class="blackHR">
        {!! Form::Label('car_part_id', 'ID súčiastky:') !!}

        <select class="form-control car-part-id-update" name="car_part_id" id="car_part_id">
            <option value="">Vyberte si ID súčiastky...</option>
            @foreach($car_parts as $car_part)
                <option  value="{{$car_part->car_part_id}}">{{$car_part->car_part_id}}</option>
            @endforeach
        </select>
        {!! Form::label('stock', 'Množstvo na sklade:') !!}
        <div class="hours-box">
            {!! Form::number('stock', $value = null, ['class' => 'form-control stock-car-part', 'required','max' => 1000, 'min' => 1]) !!}
        </div>
        <div class="text-center ">
            <button type="submit" class="btn btn-warning btn-lg">Aktualizuj množstvo</button>
        </div>
        {{ Form::close() }}
    </div>
@endsection