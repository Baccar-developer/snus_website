<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class charts extends Model
{
    use HasFactory;
    protected $fillable =['customer_id'];
}
