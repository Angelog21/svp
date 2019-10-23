@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Datos de la solicitud")])
@endsection

@section('content')
<div class="container">
        <div class="row">
            @if (isset($especial))
                @include('partials.data.totales',['periods'=>$datos['periods'],'available_days'=>$datos['available_days'],'request_days'=>$datos['request_days'],'restant'=>$datos['restant'],'freedays'=>$datos['freedays'],'especial'=>$especial])
            @else
                @include('partials.data.totales',['periods'=>$datos['periods'],'available_days'=>$datos['available_days'],'request_days'=>$datos['request_days'],'restant'=>$datos['restant'],'freedays'=>$datos['freedays']])
            @endif
            @include('partials.data.fechas',['fi'=>substr($datos['fi'],0,-9),'ff'=>substr($datos['ff'],0,-9),'refund_date'=>substr($datos['refund_date'],0,-9)])
            @include('partials.data.flujo',['approver'=>$datos['approver'][0]->person->name,'supervisor'=>$datos['supervisor'] ? $datos['supervisor'][0]->person->name : 'No hay Coordinador'])
        </div>
        <form action="{{ route('holidays.store') }}" method="POST">
            @csrf
            @if (!$datos['periods'])
                <input type="hidden" name="period_id" value="{{ null }}">
            @else
                <input type="hidden" name="p" value="{{count($datos['periods'])}}">
                @for ($i = 0; $i < count($datos['periods']); $i++)
                    <input type="hidden" name="period_{{$i+1}}" value="{{ $datos['periods'][$i]->id }}">
                @endfor
            @endif
            @if (isset($especial))
                <input type="hidden" name="especial" value="true">
            @endif
            <input type="hidden" name="available_days" value="{{ $datos['available_days'] }}">
            <input type="hidden" name="request_days" value="{{ $datos['request_days'] }}">
            <input type="hidden" name="freedays" value="{{ $datos['freedays'] }}">
            <input type="hidden" name="approver_id" value="{{ $datos['approver'][0]->id }}">
            <input type="hidden" name="supervisor_id" value="{{ $datos['supervisor'] ? $datos['supervisor'][0]->id : null }}">
            <input type="hidden" name="applicant_id" value="{{ auth()->user()->person->id }}">
            <input type="hidden" name="fi" value="{{ substr($datos['fi'],0,-9) }}">
            <input type="hidden" name="ff" value="{{ substr($datos['ff'],0,-9) }}">
            <input type="hidden" name="refund_date" value="{{ substr($datos['refund_date'],0,-9) }}">
            <div class="row">
                <div class="col s12 center">
                    <h5 class="center" style="margin-top:50px;"></h5>
                        <button class="btn waves-effect light-blue darken-3 hoverable" type="submit">Solicitar<i class="material-icons right">send</i></button>
                </div>
            </div>
    </form>
</div>
@endsection
