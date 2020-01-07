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
    <img src="image/cintillo.png" width="100%">
    <h1 align="center">CONSTANCIA DE VACACIONES</h1>
    <p align="right">{{ Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p>
        Por medio de la presente constancia de vacaciones laborales, la Oficina de Gestión Humana
        hace constar que el {{$supervisor->role->name}} {{$supervisor->person->name}} portador de la CI {{$supervisor->person->card_id}}
        ha revisado la solicitud de vacaciones, y el {{$approver->role->name}} {{$approver->person->name}} portador de la CI {{$approver->person->card_id}}
        ha aprobado el disfrute de esta solicitud en la fecha de {{substr($holiday->updated_at,0,-9)}}.
    </p>
    <h4 align="center">Datos Personales</h4>
    <table style="border:1.5px black solid" align="center" width="100%">
        <thead style="border-bottom:1.5px black solid; text-align:center; background:darkgray">
            <tr>
                <th>Nombre Completo</th>
                <th>Cédula</th>
                <th>Oficina</th>
                <th>Cargo</th>
                <th>Extensión</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align:center">
                <td>{{$applicant->person->name}}</td>
                <td>{{$applicant->person->card_id}}</td>
                <td>{{$applicant->office->acronimo}}</td>
                <td>{{$applicant->role->name}}</td>
                <td>{{$applicant->person->extension}}</td>
                <td>{{$applicant->person->phone}}</td>
                <td>{{$applicant->email}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h4 align="center">Datos de Fechas</h4>
    <table style="border:1.5px black solid" align="center" width="100%">
        <thead style="border-bottom:1.5px black solid; text-align:center; background:darkgray">
            <tr>
                <th>Fecha de Inicio</th>
                <th>Fecha de Finalización</th>
                <th>Fecha de Reintegro</th>
                <th>Período/s a consumir</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align:center">
                <td>{{$holiday->start_date}}</td>
                <td>{{$holiday->end_date}}</td>
                <td>{{$holiday->refund_date}}</td>
                <td>
                    @foreach ($holiday->periods as $p)
                        {{$p->period}}<br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <h4 align="center">Días totales</h4>
    <table style="border:1.5px black solid" align="center" width="100%">
        <thead style="border-bottom:1.5px black solid; text-align:center; background:darkgray">
            <tr>
                <th>Días solicitados</th>
                <th>Días feriados</th>
                <th>Días Restantes</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align:center">
                <td>{{$holiday->request_days}}</td>
                <td>{{$freedays}}</td>
                <td>{{$days}}</td>
            </tr>
        </tbody>
    </table>
    <hr width="300px" style="margin-top:200px">
    <p align="center">Firma {{$applicant->person->name}}</p>
</body>
</html>
