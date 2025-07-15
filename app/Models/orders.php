<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable =['quantity' ,'order_price','governorate' ,'location' ,
        'state' ,'delivered_at' ,'product_name' ,'tel','payed'];
}
