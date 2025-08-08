<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class orders extends Model
{
    use HasFactory;
    protected $fillable=["chart_id" , "location" , "order_status" , "delivered_at" ,"price_per_DT"];
}
