<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = [
            'Joel',
            'Ellie',
            'Tess',
            'Tommy',
            'Bill',
        ];
        $title = "Listado de Usuarios";
        // $users = [];
        $title = "Listado de usuarios";
       return view('users.index',compact('users','title'));
    }

    public function show($id){
        return view('users.show',compact('id'));
    }

    public function create(){
        $title = "Nuevo usuario";
        return view('users.new',compact('title'));
    }
}
