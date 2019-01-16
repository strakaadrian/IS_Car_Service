@extends('app')

@section('title','Kontakt')

@section('content')
    <div class="order-service">
        <div class="sectionHeader">
            <h2 class="text-center"> Kontakt </h2>
            <hr class="blackHR">
        </div>
        {{ Form::open() }}
        <div class="form-group">
            {!! Form::Label('car_service', 'Prosím vyberte si autoservis:') !!}
            {!! Form::select('car_service', $car_services, null, ['class' => 'form-control', 'id' => 'car_service_contact', 'placeholder' => 'Vyberte autoservis...']) !!}
        </div>
        {{ Form::close() }}


        <div class="contact-box">
            <div class="text-center">
                <p class="service-contact"><i class="fa fa-car"></i> Autoservis: <span id="service-name"></span> </p>
                <p class="service-contact"><i class="glyphicon glyphicon-home"></i> Mesto: <span id="service-town"></span> </p>
                <p class="service-contact"><i class="fa fa-road"></i>Ulica: <span id="service-street"></span> </p>
                <p class="service-contact"><i class="fa fa-address-book"></i></i> Adresa: <span id="service-oc"></span> </p>
                <p class="service-contact"><i class="fa fa-phone-square"></i> Mobil: <span id="service-phone"></span> </p>
                <p class="service-contact"><i class="fa fa-envelope"></i> Email: <span id="service-email"></span> </p>
            </div>
        </div>



    </div>



@endsection