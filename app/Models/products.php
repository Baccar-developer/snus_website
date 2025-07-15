<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable=['name' ,'description' ,'price_per_DT' , 'full_quantity' ,
        'ordered_quantity','gains_per_DT' ,'ratings' , 'rate' ,'sold_quantity' ,'image'];
}
