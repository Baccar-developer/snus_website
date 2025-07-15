<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class admins extends Authenticatable
{
    protected $fillable=['name' , 'password'];
    public $timestamps = false;
}
