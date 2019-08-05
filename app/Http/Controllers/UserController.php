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
        return view('users.new',compact('title'));
    }
}
