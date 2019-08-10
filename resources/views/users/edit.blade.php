@extends('layout')

@section('title',"Editar usuario")

@section('content')
    <h1>Editar usuario</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <h6> Por favor corrige los errores debajo:</h6>
    </div>
    @endif
    
    <form method="POST" action="{{ route('user.update',['user' => $user]) }}">
        <label for="name">Nombre:</label>
        <input class="form-input" type="text" name="name" id="name" placeholder="juan perez" value="{{ old('name', $user->name) }}"/>
        @if($errors->has('name'))
            <p>{{ $errors->first('name') }}</p>
        @endif
        <br><br>
        <label for="email">Correo:</label>
        <input class="form-input" type="email" name="email" id="email" placeholder="juan.perez@example.mx" value="{{ old('email', $user->email) }}"/>
        @if($errors->has('email'))
            <p>{{ $errors->first('email') }}</p>
        @endif
        <br><br>
        <label for="password">Contraseña:</label>
        <input class="form-input" type="password" name="password" id="password" placeholder="Mayor a 6 caracteres"/>
        <br><br>
        {!! method_field('PUT') !!}
        {!! csrf_field() !!}
        <button type="submit">Actualizar usuario</button>
    </form>

    <p> <a href="{{ route('users.index') }}">Regresar</a></p>
@endsection