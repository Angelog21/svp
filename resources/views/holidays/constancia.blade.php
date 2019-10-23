<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Constancia de vacaciones</title>
</head>
<body>
    <h1 align="center">CONSTANCIA DE VACACIONES</h1>
    <h2 align="center">Ministerio del Poder Popular para la Educacion Universitaria</h2>
    <p align="right">{{ Carbon\Carbon::now()->format('d-m-Y') }}</p>
    <p>
        Por medio de la presente constancia de vacaciones laborales, la Oficina de Gestión Humana
        hace constar que el solicitante: {{$applicant->person->name}} portador de la CI {{$applicant->person->card_id}}
        perteneciente a la {{$applicant->area->direction->office->acronimo}} disfrutará de un periodo de vacaciones
        el cual tendra como Fecha de inicio {{$holiday->start_date}}, Fecha de Finalización {{$holiday->end_date}} y
        Fecha de Reintegro {{$holiday->refund_date}}, solicitud que ha sido revisada por el coordinador de area {{$supervisor->person->name}}
        y aprobada por el director {{$approver->person->name}} en la fecha de {{substr($holiday->updated_at,0,-9)}}
    </p>

    <p style="margin-top:300px" align="center">Firma {{$applicant->person->name}}</p>
</body>
</html>
