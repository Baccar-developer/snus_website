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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name' ,20)->unique();
            $table->float('price_per_DT');
            $table->text('product_desc');
            $table->unsignedInteger('full_qnt');
            $table->unsignedInteger('wished_qnt')->default(0);
            $table->unsignedInteger('ordered_qnt')->default(0);
            $table->float('product_rate')->default(0);
            $table->unsignedInteger('ratings')->default(0);
            $table->string('product_image' ,100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
