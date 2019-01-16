@extends('app')

@section('title','Objednávka služby')

@section('content')
    <div class="order-service">
        <div class="sectionHeader">
            <h2 class="text-center"> Objednávka služby </h2>
            <hr class="blackHR">
        </div>

        @if(!Auth::user()->isCustomer())
            <p>Vidim, že stále nieste u nás zákazníkom.</p>
            <p>Pred pokračovaním na objednávku služby - <strong>{{$service[0]->name}}</strong> prosím vyplnte formulár uvedený nižšie.</p>

            {{ Form::open(array('action' => 'ServiceController@createCustomer', 'id' => 'facturation-id')) }}
            <div class="form-group">
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

                <div class="medium-box">
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
                </div>
                <div class="alert alert-warning error-facturation-div" role="alert">
                    <p id="error-facturation-msg"></p>
                </div>
                <div class="text-center facturation-submit ">
                    <button id="submit-facturation-button" type="button" class="btn btn-warning btn-lg">Odošli formulár</button>
                </div>
            </div>
            {{ Form::close() }}
        @else
            <p> Vitajte vo formulári, na dokončenie objednávky pre službu - <strong>{{$service[0]->name}}</strong>.</p>
            <p>Prosím, pre dokončenie objednávky vyplnte nižšie uvedené položky. </p>

            {{ Form::open(array('action' => 'ServiceController@insertReservation', 'id' => 'order-service-id')) }}

            <div class="form-group">
                <div class="medium-box">
                    {!! Form::Label('ico', 'Autoservis:') !!}
                    {!! Form::select('car_service', $car_services, null, ['class' => 'form-control', 'id' => 'car_service]) !!}

                    {!! Form::label('date', 'Deň, na ktorý sa chcete objednať:') !!}
                    <div class="date-box">
                        {!! Form::date('date',null, ['class' => 'form-control hours-box', 'required']); !!}
                    </div>
                    {!! Form::label('hour', 'Hodina, na ktorú sa chcete objednať:') !!}
                    <div class="hours-box">
                        {!! Form::select('hour', array( 7 => 7 , 8 => 8 , 9 => 9, 10 => 10, 11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15, 16 => 16, 17 => 17), null, array('class'=>'form-control')) !!}
                    </div>
                </div>
                <div class="alert alert-warning error-order-div" role="alert">
                    <p id="error-order-msg"></p>
                </div>
                <div class="text-center customer-submit ">
                    <button id="submit-order-button" type="button" class="btn btn-warning btn-lg">Odošli formulár</button>
                </div>
                {!! Form::hidden('id',$id , array('id' => 'id'))  !!}
            </div>
            {{ Form::close() }}
        @endif
    </div>
@endsection