@extends('app')

@section('title', 'Domov')

@section('content')

    <div class="container-fluid bg-1 text-center home-block">
        <div class="sectionHeader">
            <h2> O nás </h2>
            <hr class="whiteHR">
        </div>
        <div class="sectionBody ">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. In rutrum. Proin pe
                de metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Fusce tellus. In enim a arcu imperdiet male
                suada. Nullam sit amet magna in magna gravida vehicula. Etiam egestas wisi a erat. Praesent vitae arcu tempor neque lacinia pretium. Mauris tincidunt sem sed arcu. Fusce tellus. Fusce suscipit libero eget elit. Aliquam erat volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                Integer lacinia. In convallis. Aenean vel massa quis mauris vehicula lacinia. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Pellentesque sapien. Nulla quis diam. In convallis. Fusce nibh. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Integer vulputate sem a nibh rutrum consequat. Praesent dapibus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Quisque tincidunt scelerisque libero. Cras elementum.
                Duis sapien nunc, commodo et, interdum suscipit, sollicitudin et, dolor. Etiam posuere lacus quis dolor. Fusce tellus.
            </p>
            <a href="{{url('about')}}" class="btn btn-warning btn-lg">
                <span class="glyphicon glyphicon-search"></span> Zistite viac
            </a>
        </div>
    </div>

    <div class="container-fluid bg-2 text-center home-block">
        <div class="sectionHeader">
            <h2 > Ponuka naších služieb </h2>
            <hr class="blackHR">
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

    <!-- Third Container (Grid) -->
    <div class="container-fluid bg-3 text-center home-block">
        <h3 class="margin">Where To Find Me?</h3><br>
        <div class="row">
            <div class="col-sm-4">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <img src="birds1.jpg" class="img-responsive margin" style="width:100%" alt="Image">
            </div>
            <div class="col-sm-4">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <img src="birds2.jpg" class="img-responsive margin" style="width:100%" alt="Image">
            </div>
            <div class="col-sm-4">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <img src="birds3.jpg" class="img-responsive margin" style="width:100%" alt="Image">
            </div>
        </div>
    </div>

@endsection
