@extends('layout')

@section('title',"Usuario # {$id}")

@section('content')
    <h1>Usuario: {{$id}}</h1>
    <h3>Mostrando detalle del usuario: {{$id}}</h3>
@endsection