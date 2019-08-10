    @extends('layout')

    @section('title',$title)
        
    @section('content')
        <h1>{{$title}}</h1>
        <a href="{{ route('user.create') }}">Crear usuario</a>
        <ul>
            @forelse ($users as $user)
                <li>
                    {{ $user->name }} - {{ $user->email }}
                    <a href="{{ route('user.show',$user) }}">Ver detalles</a> |
                    <a href="{{ route('user.edit',$user) }}">Editar</a>
                    <form action="{{ route('user.destroy', $user) }}" method="POST">
                        {!! method_field('DELETE') !!}
                        {!! csrf_field() !!}
                        <button type="submit"> Eliminar </button>
                    </form>
                </li>
            @empty
                <li>No hay usuarios registrados.</li>
            @endforelse
        </ul>
    @endsection

    @section('sidebar')

        @parent

        <h1>Seccion del side bar de ejemplo</h1>
        
    @endsection
    

    