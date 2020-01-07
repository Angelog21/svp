@extends('layouts.app')

@section('title')
    @include('partials.title.general', [
        'title' => __("Confirmar Reintegro")
    ])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <form action="{{ route('permits.refundPermit',$permit->id)}}" method="POST">
            @method('PUT')
            @csrf
            <div class="col s12">
            <h5 class="center" style="margin-top:50px;">Observación</h5>
                <div class="input-field">
                    <input type="text" name="observation">
                </div>
            </div>
            <div class="col s12 center">
                <h5 class="center" style="margin-top:50px;"></h5>
                <button class="btn waves-effect green darken-3 hoverable" type="submit" name="action">Confirmar<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>
@endsection
