<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class products extends Model
{
    protected $fillable=['product_name' ,'product_desc' ,'price_per_DT' , 'full_qnt' ,
        'ordered_qnt',"wished_qnt" ,'ratings' , 'product_rate' ,'product_image'];
    
    use HasFactory;
}
