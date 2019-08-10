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
            'password' => 'required|between:6,12',
        ],[
            'name.required' => 'El campo nombre es obligatorio',
        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user){
        $title = "Editar usuario";
        return view('users.edit',compact('title','user'));
    }

    public function update(User $user){
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => '',
        ]);

        if($data['password'] != null){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('user.show',['user' => $user]);
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.index');
    }
}
