@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Seleccione una opción")])
@endsection

@section('content')
    @include('partials.permitMenus.'.auth()->user()->role->name)    
@endsection