    @extends('layout')

    @section('title',$title)
        
    @section('content')
        <h1>{{$title}}</h1>
        <ul>
            @forelse ($users as $user)
                <li>{{$user}}</li>
            @empty
                <li>No hay usuarios registrados.</li>
            @endforelse
        </ul>
    @endsection

    @section('sidebar')

        @parent

        <h1>Seccion del side bar de ejemplo</h1>
        
    @endsection
    

    