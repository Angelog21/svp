@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Manuales")])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @include('partials.manuals.employee')
            @if (auth()->user()->role_id == \App\Role::DIRECTOR_LINEA || auth()->user()->role_id == \App\Role::SUPERADMIN || auth()->user()->role_id == \App\Role::DIRECTOR_GENERAL)
                @include('partials.manuals.superadmin')
            @endif
        </div>
    </div>
@endsection
