@extends('app')

@section('title')
    Registrácia
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 register">
            <div class="card">
                <div class="card-header text-center">{{ __('Registrácia') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row text-center">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Meno :') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row text-center">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mailová adresa :') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row text-center">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Heslo :') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row text-center">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Potvrdiť heslo :') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0 submit-button">
                            <div class="col-md-12 offset-md-4 text-center">
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Registrovať') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
