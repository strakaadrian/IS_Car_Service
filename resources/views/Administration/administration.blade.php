@extends('app')

@section('title', 'Administratíva')

@section('content')
    <div class="row row-admin ">
        <div class="container-sidebar col-md-2">
            <div class="sidebar">
                <ul class="nav sidebar-nav sidebar-left" id="admin-menu-items">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Správa zamestnancov
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-admin" style="color: black">
                            <li><a href="{{url('administration/add-employee')}}"> Pridaj zamestnanca </a></li>
                            <li><a href="{{url('administration/update-employee')}}"> Aktualizuj zamestnanca </a></li>
                            <li><a href="{{url('administration/terminate-employee')}}"> Ukonči p. pomer </a></li>
                            <li><a href="{{url('administration/absence')}}"> Správa absencii </a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Správa zákazníkov
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-admin" style="color: black">
                            <li><a href="{{url('administration/add-customer')}}"> Vytvor zákazníka </a></li>
                            <li><a href="{{url('administration/admin-reservations')}}"> Rezervácie</a></li>
                        </ul>
                    </li>
                    @if(!Auth::guest())
                        @if(Auth::user()->isSuperAdmin() && Auth::user()->isWareHouse())
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Správa autosúčiastok <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-admin" style="color: black">
                                    <li><a href="{{url('administration/watch-car-parts')}}"> Stav na sklade </a></li>
                                    <li><a href="{{url('administration/administrate-car-parts')}}"> Správa autodielov </a></li>
                                </ul>
                            </li>
                        @endif
                        @if(Auth::user()->isSuperAdmin() && Auth::user()->isServiceAdmin())
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Správa služieb<span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-admin" style="color: black">
                                    <li><a href="{{url('administration/admin-services')}}"> Zobraz služby </a></li>
                                    <li><a href="{{url('administration/addService')}}"> Pridaj službu </a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Grafy <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-admin" style="color: black">
                            <li><a href="{{url('administration/week-reservations')}}"> Počty rezervácii na najbl. týžden </a></li>
                            @if(Auth::user()->isSuperAdmin())
                                <li><a href="{{url('administration/number-of-orders')}}"> Počty objednávok za najbližšie dni </a></li>
                                <li><a href="{{url('administration/best-month-earnings')}}"> Najlepšie zarabajúce firmy mesiaca </a></li>
                                <li><a href="{{url('administration/best-car-parts-sales')}}"> Najlepšie zarabajúce produkty </a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 admin-body">
            @yield('admin-content')
        </div>
    </div>
@endsection