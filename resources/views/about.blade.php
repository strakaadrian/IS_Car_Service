@extends('app')

@section('title','O nás')

@section('content')
<div class="container-fluid bg-1 text-center home-block">
    <div class="sectionHeader">
        <h2> O nás </h2>
        <hr>
    </div>
    <div class="sectionBody ">
        <p>
            Car world je súkromná spoločnosť, ktorá ponúka široký sortiment služieb pre našich zákazníkov.Naša spoločnosť je na trhu od roku 2012 ako súkromný podnik fyzickej osoby, ktorá si stihla za čas strávený na trhu vybudovať silné miesto, ktoré je zárukou kvalitných výrobkov a služieb. V našej firme si môžete vopred zarezervovať  termín pre lakýrnické, elektroinštalačné, mechanické a karosárske práce. V nižšie uvedenom zozname sú uvedené niektoré zo služieb, ktoré ponúkame.
        </p>
    </div>
    <a href="#service-list" class="btn btn-warning" data-toggle="collapse">Zobraz zoznam služieb</a>
    <div id="service-list" class="collapse">
        <div class="sectionHeader">
            <h2 > Ponuka naších služieb </h2>
        </div>
        @foreach($services as $service)
            <p>{{ $service->name }}</p>
        @endforeach
        <p>. . .</p>
        <p>. . .</p>
        <p>Pre zobrazenie všetkých naších služieb, kliknite na tlačidlo <strong>'Zobrazit viac'</strong>.</p>
        <a href="{{url('service')}}" class="btn btn-warning btn-lg">
            <span class="glyphicon glyphicon-search"></span> Zobrazit viac
        </a>
    </div>
</div>
@endsection