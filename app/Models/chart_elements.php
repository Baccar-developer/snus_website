<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chart_elements extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingsFactory> */
    use HasFactory;
    protected $fillable=["chart_id" ,"product_id" ,'qnt'];
}
