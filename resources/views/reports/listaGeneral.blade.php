<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Constancia de vacaciones</title>
    <style>
        body{
            font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
        }
    </style>
</head>
<body>
    <img src="{{asset('image/cintillo.png')}}" width="100%">
    <h1 align="center">{{$title}}</h1>
    <p align="right">{{ Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <table style="border:1.5px black solid" align="center" width="100%">
        <thead style="border-bottom:1.5px black solid; text-align:center; background:darkgray">
            <tr>
                <th>Nombre Completo</th>
                <th>Cédula</th>
                <th>Oficina</th>
                <th>Cargo</th>
                <th>Fecha de reintegro</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($holidays as $holiday)
            <tr style="text-align:center">
                <td>{{$holiday->applicant->person->name}}</td>
                <td>{{$holiday->applicant->person->card_id}}</td>
                <td>{{$holiday->applicant->office->acronimo}}</td>
                <td>{{$holiday->applicant->role->name}}</td>
                <td>{{$holiday->refund_date}}</td>
            </tr>
            @empty
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
