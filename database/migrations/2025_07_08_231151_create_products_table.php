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
            $table->id();
            $table->string('name' ,20)->unique();
            $table->float('price_per_DT');
            $table->text('description');
            $table->integer('full_quantity');
            $table->integer('ordered_quantity');
            $table->float('gains_per_DT');
            $table->double('rate' , 1,3);
            $table->unsignedInteger('ratings');
            $table->unsignedInteger('sold_quantity');
            $table->string('image' ,100);
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
