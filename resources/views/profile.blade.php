@extends('app')

@section('title','Profil')


@section('content')
    <div class="order-service">
        <div class="sectionHeader">
            <h2 class="text-center"> Profil </h2>
            <hr class="blackHR">
        </div>
        @if(Auth::user()->isCustomer())
            <p>Tu si môžete zmeniť fakturačné údaje. </p>

            {{ Form::open(array('action' => 'ProfileController@updateProfile', 'id' => 'profile-id')) }}
                <div class="medium-box">
                    <div class="form-group">
                        {!! Form::Label('country_id', 'Štát:') !!}
                        <select class="form-control" name="country_id" id="country_id">
                            @foreach($countries as $country)
                                @if($country->country_id == $customer[0]->country_id)
                                    <option selected="selected" value="{{$country->country_id}}">{{$country->country_name}}</option>
                                @else
                                    <option  value="{{$country->country_id}}">{{$country->country_name}}</option>
                                @endif
                            @endforeach
                        </select>

                        {!! Form::label('town', 'Mesto:') !!}
                        {!! Form::text('town', $value = $customer[0]->town_name, ['class' => 'form-control', 'required']); !!}
                        <div class="small-box">
                            {!! Form::label('psc', 'Psč:') !!}
                            {!! Form::text('psc', $value = $customer[0]->town_id, ['class' => 'form-control','maxlength' => 5, 'required']); !!}
                        </div>

                        {!! Form::label('name', 'Meno:') !!}
                        {!! Form::text('name', $value = $customer[0]->first_name, ['class' => 'form-control', 'required']); !!}

                        {!! Form::label('surname', 'Priezvisko:') !!}
                        {!! Form::text('surname', $value = $customer[0]->last_name, ['class' => 'form-control', 'required']); !!}

                        {!! Form::label('street', 'Ulica:') !!}
                        {!! Form::text('street', $value = $customer[0]->street, ['class' => 'form-control', 'required']); !!}

                        {!! Form::label('orientation_no', 'Č. domu:') !!}
                        {!! Form::number('orientation_no', $value = $customer[0]->orientation_no, ['class' => 'form-control', 'required']); !!}
                    </div>
                </div>
                <div class="alert alert-danger error-profile-div" role="alert">
                    <p id="error-profile-msg"></p>
                </div>
                <div class="text-center customer-submit ">
                    <button id="submit-profile-button" type="button" class="btn btn-warning btn-lg">Uložiť profil</button>
                </div>

            {{ Form::close() }}

        @else

            <p> Prepáčte, ale nieste u nás zákazníkom, zatiaľ nemáte fakturačné údaje </p>

        @endif

    </div>

@endsection
