@extends('app')

@section('title','Moje objednávky')


@section('content')
    <div class="order-service">
        <div class="sectionHeader">
            <h2 class="text-center"> Objednávky </h2>
            <hr class="blackHR">
        </div>
        <div>
            <table class="table">
                <thead class="service-table-head">
                <tr>
                    <th class="text-center"> ID objednávky </th>
                    <th class="text-center"> Status </th>
                    <th class="text-center"> Dátum objednávky </th>
                    <th class="text-center"> PDF </th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="text-center service-row"> {{ $order->order_id }} </td>
                        <td class="text-center service-row"> {{ $order->status }} </td>
                        <td class="text-center service-row"> {{ $order->order_date }} </td>
                        @if($order->status != 'zrusena')
                            <td class="text-center service-row"><a href="order-to-pdf/{{$order->order_id}}" class="btn btn-default" role="button">Zobraz faktúru </a></td>
                        @else
                            <td class="text-center service-row"></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection