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

        @else

        @endif

    </div>
@endsection