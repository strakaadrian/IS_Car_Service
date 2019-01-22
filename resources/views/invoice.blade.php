<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faktúra</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style type="text/css">
        * {
            font-family: DejaVu Sans !important;
        }
    </style>

</head>
<body>

<table width="100%">
    <tr>
        <td align="left">
            <h1> Faktúra </h1>
        </td>
        <td align="right">
            Č. objednávky: {{ $id }}
        </td>
    </tr>
    <hr>
    <tr>
        <td align="left">
            <address>
                <h3> Dodávateľ </h3>
                Car world a.s.<br>
                Bratislavská 247/7 <br>
                952 45 Bratislava<br>

            </address>
        </td>
        <td align="right">
            <h3> Odoberateľ </h3>
            <address>
                {{ $person[0]->first_name }} {{ $person[0]->last_name }} <br>
                {{ $person[0]->street }} {{ $person[0]->orientation_no }}<br>
                {{ $person[0]->town_id }} {{ $person[0]->town_name }}<br>
            </address>
        </td>
    </tr>
</table>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Zhrnutie objednávky</strong></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        @if(!$reservations->isEmpty())
                            <thead>
                                <tr>
                                    <td><strong>Služba</strong></td>
                                    <td class="text-center"><strong> Hod. práce </strong></td>
                                    <td class="text-center"><strong> Suma/hod </strong></td>
                                    <td class="text-right"><strong> Spolu </strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                    <tr>
                                        <td>{{  $reservation->name }}</td>
                                        <td class="text-center"> {{ $reservation->work_hours  }} </td>
                                        <td class="text-center"> {{ $reservation->price_per_hour  }} &euro;</td>
                                        <td class="text-right">{{ $reservation->work_hours*$reservation->price_per_hour }} &euro;</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif

                        @if(!$carParts->isEmpty())
                                <thead>
                                    <tr>
                                        <td><strong>Súčiastka</strong></td>
                                        <td class="text-center"><strong>Cena</strong></td>
                                        <td class="text-center"><strong>Množstvo</strong></td>
                                        <td class="text-right"><strong>Spolu</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carParts as $carPart)
                                        <tr>
                                            <td>{{  $carPart->part_name }}</td>
                                            <td class="text-center"> {{ $carPart->part_price  }} &euro;</td>
                                            <td class="text-center"> {{ $carPart->quantity  }}</td>
                                            <td class="text-right">{{ $carPart->part_price*$carPart->quantity }} &euro;</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        @endif
                    </table>
                    <hr>
                    <p class="text-right" style="padding-right: 1%">Celkovo spolu: {{ $sum }} &euro;</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>