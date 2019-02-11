@extends('Administration/administration')

@section('title', 'Správa rezervácii')

@section('admin-content')
    <div class="sectionHeader">
        <h2 class="text-center"> Vitajte v menu pre správu rezervácii zákazníkov. </h2>
        <hr class="blackHR">
    </div>
    <div class="admin-reservation-table">
        <table class="table">
            <thead>
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Firma</th>
                <th class="text-center" scope="col">Zákazník</th>
                <th class="text-center" scope="col">Služba</th>
                <th class="text-center" scope="col">Dátum / čas </th>
                <th class="text-center" scope="col">Odpr. hodín</th>
                <th class="text-center" scope="col">Zrušiť</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservations as $reservation)
                <tr>
                    <td class="text-center service-row ">{{$reservation->reservation_id}}</td>
                    <td class="text-center service-row ">{{ $reservation->service_name }}</td>
                    <td class="text-center service-row "> {{ $reservation->first_name }} {{ $reservation->last_name }}</td>
                    <td class="text-center service-row "> {{ $reservation->name }}</td>
                    <td class="text-center service-row "> {{ $reservation->repair_date }}</td>
                    <td class="text-center service-row "> {{ $reservation->work_hours }}</td>
                    <td class="text-center service-row "><button type="button" class="btn btn-default reservation-delete-admin" id="{{$reservation->reservation_id}}"><i class="fa fa-trash"></i> Zrušiť </button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="small-box" style="margin-bottom: 5%">
        {{ Form::open(array('action' => 'ReservationController@realizeReservation')) }}
        <h3>Zrealizuj rezerváciu:</h3>
        <hr class="blackHR">
        {!! Form::Label('reservation_id', 'Id rezervácie:') !!}

            <select class="form-control complete-reservation-id" name="reservation_id" id="reservation_id">
                    <option value="">Vyberte si rezerváciu</option>
                @foreach($reservations as $reservation)
                    <option  value="{{$reservation->reservation_id}}">{{$reservation->reservation_id}}</option>
                @endforeach
            </select>
        {!! Form::label('work_hours', 'Trvanie prác:') !!}
        <div class="hours-box">
            {!! Form::number('work_hours', $value = null, ['class' => 'form-control complete-reservation-hours', 'required','max' => 10, 'min' => 1]); !!}
        </div>
        <div class="text-center ">
            <button type="submit" class="btn btn-warning btn-lg">Zrealizuj rezerváciu</button>
        </div>

        {{ Form::close() }}
    </div>

@endsection