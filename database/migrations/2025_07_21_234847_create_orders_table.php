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
        Schema::create('orders', function (Blueprint $table) {
            $table->id("order_id");
            $table->string('location' , 100);
            $table->enum("order_status", ["delivered" ,"canceled","unfulfilled"]);
            $table->dateTime("delivered_at")->nullable(true);
            
            $table->foreignId("chart_id")->constrained("charts" ,"chart_id");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
