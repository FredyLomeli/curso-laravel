<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Profession;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    public static function findByEmail($email){
        // El fasa static se usa cuando se quiere llamar al modelo en el que nos encontramos
        return static::where(compact('email'))->first();
    }

    public function isAdmin(){
        return $this->email === 'ing.lomeli@gmail.com';
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }
}
