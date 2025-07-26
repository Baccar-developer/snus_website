<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            
            $table->id("payment_id")->primary();
            $table->unsignedBigInteger("order_id")->unique();
            
            
            $table->float("payed_amount" ,3);
            $table->string("currency" ,3)->default('DTN');
            $table->enum("payment_status" , ["Complete" ,"InComplete" , "Processing"]);
            
            $table->string("transaction_id", 18)->unique();
            $table->text("gateway_response");
            $table->timestamps();
            
            $table->foreign("order_id")->references("order_id")->on("orders")->onDelete("cascade")->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
