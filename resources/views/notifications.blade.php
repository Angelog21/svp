@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Mis notificaciones")])
@endsection

@section('content')
    <div class="container">
        <ul class="collection">
            @forelse ($n as $val)
                <li class="collection-item avatar">
                    <i class="material-icons circle yellow darken-2">add</i>
                    <h3 class="title">
                        {{$val->title}}
                    </h3>
                    <p>{{ $val->origin->person->name." ".$val->description }}</p>
                    <small>
                        {{substr($val->created_at,0,-3)}}
                    </small>
                </li>
            @empty
                <li>No tiene notificaciones</li>
            @endforelse
        </ul>
    </div>
@endsection