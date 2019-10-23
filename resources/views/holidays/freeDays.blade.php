@extends('layouts.app')

@section('title')
    @include('partials.title.general', [
        'title' => __("Días Feriados")
    ])
@endsection

@section('content')
<div class="container">
    @if (auth()->user()->role->id == App\Role::ANALISTA_VACACIONES)
        @include('partials.freedays.form')
        <br><br>
        @include('partials.freedays.dataEspecial')
    @else
        @include('partials.freedays.data')
    @endif
</div>
@endsection
