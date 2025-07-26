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
        Schema::create('chart_elements', function (Blueprint $table) {
            $table->foreignId("product_id")->constrained('products' , 'product_id');
            $table->foreignId("chart_id")->constrained('charts' , 'chart_id');
            $table->integer("qnt");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
