@extends('app')

@section('title','Služby')

@section('content')
<div class="container-fluid bg-2  home-block">
    <div class="sectionHeader">
        <h2 class="text-center"> Ponuka naších služieb </h2>
        <hr class="blackHR">
    </div>
    <div class="service-table">
        <table class="table">
            <thead class="service-table-head">
                <tr>
                    <th class="text-center">Služba</th>
                    <th class="text-center">€/hod</th>
                    <th class="text-center">Objednať</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td class="text-center service-row">{{$service->name}}</td>
                        <td class="text-center service-row">{{$service->price_per_hour}} €</td>
                        <td class="text-center service-row"><button type="button" id="{{$service->service_id}}" class="btn btn-default service-order-button" name="order-service"  value="">Objednaj službu</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection