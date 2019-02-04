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
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"> Správa súčiastok <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-admin" style="color: black">
                                    <li><a href="{{url('administration/watch-car-parts')}}"> Stav na sklade </a></li>
                                    <li><a href="{{url('administration/administrate-car-parts')}}"> Správa autodielov </a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                    <li><a href="#">Users</a></li>
                    <li><a href="#">Sign Out</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 admin-body">
            @yield('admin-content')
        </div>
    </div>

@endsection