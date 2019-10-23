<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Constancia de permiso</title>
</head>
<body>
    <h1 align="center">CONSTANCIA DE PERMISO</h1>
    <h2 align="center">Ministerio del Poder Popular para la Educacion Universitaria</h2>
    <p align="right">{{ Carbon\Carbon::now()->format('d-m-Y') }}</p>
    @if (isset($turno))
    <p>
        Por medio de la presente constancia de permiso laboral, la Oficina de Gestión Humana
        hace constar que el solicitante: {{$applicant->person->name}} portador de la CI {{$applicant->person->card_id}}
        perteneciente a la {{$applicant->area->direction->office->acronimo}} estará de permiso por el turno de la {{$turno}}
        debido a {{$permit->reason->name}},
        el cual tendra como Fecha de inicio {{$permit->start_date}}, Fecha de Finalización {{$permit->end_date}} y
        Fecha de Reintegro {{$permit->refund_date}}, solicitud que ha sido aprobada por el coordinador de area {{$supervisor->person->name}}
        en la fecha de {{substr($permit->updated_at,0,-9)}}
    </p>
    @else
    <p>
        Por medio de la presente constancia de permiso laboral, la Oficina de Gestión Humana
        hace constar que el solicitante: {{$applicant->person->name}} portador de la CI {{$applicant->person->card_id}}
        perteneciente a la {{$applicant->area->direction->office->acronimo}} estará de permiso por los dias {{$permit->days}}
        debido a {{$permit->reason->name}},
        el cual tendra como Fecha de inicio {{$permit->start_date}}, Fecha de Finalización {{$permit->end_date}} y
        Fecha de Reintegro {{$permit->refund_date}}, solicitud que ha sido aprobada por el coordinador de area {{$supervisor->person->name}}
         en la fecha de {{substr($permit->updated_at,0,-9)}}
    </p>
    @endif

    <p style="margin-top:300px" align="center">Firma {{$applicant->person->name}}</p>
</body>
</html>
