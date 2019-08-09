<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        $title = "Listado de Usuarios";
        // $users = [];
        $title = "Listado de usuarios";
       return view('users.index',compact('users','title'));
    }

    public function show(User $user){
        // $user = User::findOrFail($id);

        return view('users.show',compact('user'));
    }

    public function create(){
        $title = "Nuevo usuario";
        return view('users.create',compact('title'));
    }

    public function store(){
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('users.index');
    }
}
