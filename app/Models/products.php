<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    protected $fillable=['product_name' ,'product_desc' ,'price_per_DT' , 'full_qnt' ,
        'shipped_qnt','gains_per_DT' ,'ratings' , 'product_rate' ,'sold_qnt' ,'image'];
    
    use HasFactory;
}
