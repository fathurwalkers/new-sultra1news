<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table = 'login';

    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'telepon',
        'token',
        'level',
        'created_at',
        'updated_at'
    ];
}
