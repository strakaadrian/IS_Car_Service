@extends('app')

@section('title','Nákupný košík')

@section('content')
    <div class="shopping-cart">
        <div class="sectionHeader">
            <h2 class="text-center"> Nákupný košík </h2>
            <hr class="blackHR">
        </div>

        @if(!$parts->isEmpty())
            <div class="container">
                {{ Form::open() }}
                <table class="table">
                    <thead class="service-table-head">
                    <tr>
                        <th class="text-center"> Obrázok </th>
                        <th class="text-center"> Názov produktu </th>
                        <th class="text-center"> Počet </th>
                        <th class="text-center"> Cena </th>
                        <th class="text-center"> Zrušiť </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($parts as $part)
                            <tr>
                                <td class="text-center service-row shopping-image"><img src="{{ asset('storage/'. $part->image) }}" alt="/"></td>
                                <td class="text-center service-row ">{{$part->part_name}}</td>
                                <td class="text-center service-row ">{{ Form::number('quantity', $value = $part->quantity, ['class' => 'form-control shopping-cart-quantity', 'id' => $part->car_part_id ,'min' => 1, 'max' => $part->stock]) }} </td>
                                <td class="text-center service-row "> {{ $part->part_price * $part->quantity }} €</td>
                                <td class="text-center service-row "><button type="button" class="btn btn-default shopping-cart-delete-button" value="{{$part->car_part_id}}"><i class="fa fa-trash"></i> Zahoď </button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ Form::close() }}

                <div class="alert alert-danger  shopping-cart-error" role="alert">
                    <p id="shopping-cart-error-msg"></p>
                </div>

                <hr class="blackHR">
                <p class="text-right cart-for-payment"> Celkovo k úhrade : <strong> {{ $forPayment }} </strong></p>

                <div class="text-center">
                    <button type="button" class="btn btn-success btn-lg" value=""><i class="fa fa-credit-card"></i> Prejdi k platbe </button>
                    <a href="{{url('products')}}"> Pokračovať v nákupe. </a>
                </div>

            </div>
        @else
            <div class="container">
                <p> V košíku sa nenachádza žiaden tovar. </p>
                <a href="{{url('products')}}"> Prejsť do obchodu. </a>
            </div>
        @endif
    </div>
@endsection