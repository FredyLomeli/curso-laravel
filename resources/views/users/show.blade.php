@extends('layout')

@section('title',"Usuario # {$user->id}")

@section('content')
    <h1>Usuario: {{$user->id}}</h1>
    <h3>Nombre: {{$user->name}}</h3>
    <h3>Correo electronico: {{$user->email}}</h3>

    <p> <a href="{{ route('users.index') }}">Regresar</a></p>
@endsection