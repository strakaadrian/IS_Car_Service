<div class="table-wrapper-scroll-y">
    <table class="table">
        <thead>
        <tr>
            <th class="text-center" scope="col">Absencia OD</th>
            <th class="text-center" scope="col">Absencia DO</th>
            <th class="text-center" scope="col">Zrušiť</th>
        </tr>
        </thead>
        <tbody>
        @foreach($emp_absence as $emp_absence)
            <tr>
                <td class="text-center service-row ">{{ $emp_absence->absence_from }}</td>
                <td class="text-center service-row "> {{ $emp_absence->absence_to }}</td>
                <td class="text-center service-row "><button type="button" class="btn btn-default absence-delete-button" value="{{$emp_absence->absence_id}}"><i class="fa fa-trash"></i> Odstrániť </button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="add-absence">
    {{ Form::open() }}

    <div class="date-box">
        {!! Form::label('absence_from', 'Začiatok absencie:') !!}
        {!! Form::date('absence_from',null, ['class' => 'form-control hours-box', 'required']) !!}

        {!! Form::label('absence_to', 'Koniec absencie:') !!}
        {!! Form::date('absence_to',null, ['class' => 'form-control hours-box', 'required']) !!}

        <div class="alert alert-danger error error-absence-div" role="alert">
            <p id="error-absence-msg"></p>
        </div>
        <div class="text-center submit-div-button absence-submit ">
            <button id="submit-absence-button" type="button" class="btn btn-warning btn-lg">Pridaj absenciu</button>
        </div>
    </div>
    {{ Form::close() }}
</div>

