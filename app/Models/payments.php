<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class payments extends Model
{
    use HasFactory;
    protected  $fillabe =['order_id' , 'payed_amount' ,"currency" , "payment_status" , "transaction_id" , "gateway_response" , "payed_at"];
}
