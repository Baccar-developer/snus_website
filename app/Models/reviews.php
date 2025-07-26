<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reviews extends Model
{
    use HasFactory;
    protected  $fillable=["customer_id" , "product_id" ,"rate" , "comment"];
}
