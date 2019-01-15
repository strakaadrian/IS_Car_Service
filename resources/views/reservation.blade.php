@extends('app')

@section('title','Moje rezervácie')


@section('content')
    <div class="order-service">
        <div class="sectionHeader">
            <h2 class="text-center"> Moje rezervácie </h2>
            <hr class="blackHR">
        </div>
        @if(!$reserv->isEmpty())
            <table class="table">
                <thead class="service-table-head">
                <tr>
                    <th class="text-center"> Firma </th>
                    <th class="text-center"> Dátum / čas </th>
                    <th class="text-center"> Služba </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($reserv as $reservation)
                        <tr>
                            <td class="text-center service-row"> {{ $reservation->service_name }} </td>
                            <td class="text-center service-row"> {{ $reservation->repair_date }} </td>
                            <td class="text-center service-row"> {{ $reservation->name }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p> Na najbližšie obdobie nemáte objednanú žiadnu službu. </p>
            <p> Ak sa chcete objednať na službu, prosím pokračujte stlačením tlačidla. </p>
            <div class="text-center">
                <a href="{{url('service')}}" class="btn btn-warning btn-lg">
                    <span class="glyphicon glyphicon-search"></span> Objednať službu
                </a>
            </div>
        @endif
    </div>
@endsection
