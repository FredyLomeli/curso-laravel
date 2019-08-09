@extends('layout')

@section('title',"Crear usuario")

@section('content')
    <h1>Crear nuevo usuario</h1>
    
    <form method="POST" action="{{ route('user.store') }}">
        <label for="name">Nombre:</label>
        <input class="form-input" type="text" name="name" id="name" placeholder="juan perez"/>
        <br><br>
        <label for="email">Correo:</label>
        <input class="form-input" type="email" name="email" id="email" placeholder="juan.perez@example.mx"/>
        <br><br>
        <label for="password">Contraseña:</label>
        <input class="form-input" type="password" name="password" id="password" placeholder="Mayor a 6 caracteres"/>
        <br><br>
        {!! csrf_field() !!}
        <button type="submit">Crear usuario</button>
    </form>

    <p> <a href="{{ route('users.index') }}">Regresar</a></p>
@endsection