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
                        </ul>
                    </li>
                    <li><a href="#">Explore</a></li>
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