@extends('layouts.app')

@section('title')
    @include('partials.title.general', [
        'title' => __("Suspender Vacaciones")
    ])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <form action="{{route('holidays.createSuspension')}}" method="post">
            @csrf
            <div class="col s3">
                <h5 class="center" style="margin-top:50px;">Fecha Reintegro</h5>
                <div class="input-field">
                    <input type="date" class="datepicker" name="fr" id="fr">
                    <input type="hidden" name="frval" id="frval">
                </div>
            </div>
            <div class="col s6">
                <h5 class="center" style="margin-top:50px;">Motivo</h5>
                <div class="input-field">
                    <input type="text" name="reason">
                </div>
            </div>
            <input type="hidden" name="employee_id" value="{{$holiday->applicant_id}}">
            <input type="hidden" name="supervisor_id" value="{{auth()->user()->id}}">
            <input type="hidden" name="holiday_id" value="{{$holiday->id}}">
            <input type="hidden" name="enjoyed_days" value="{{$enjoyed}}">
            <input type="hidden" name="leftover_days" value="{{$remaining}}">
        @include('partials.suspension.data',['h'=>$holiday,'remaining'=>$remaining,'enjoyed'=>$enjoyed])
        <div class="col s12 center">
            <h5 class="center" style="margin-top:50px;"></h5>
            <button class="btn waves-effect light-blue darken-3 hoverable" type="submit" name="action">Suspender<i class="material-icons right">send</i></button>
        </div>
    </form>
    </div>
</div>
@endsection
