@extends('layout')

@section('title',$title)

@section('content')
    <h1>Crear nuevo usuario</h1>
    <p> <a href="{{ route('users.index') }}">Regresar</a></p>
@endsection