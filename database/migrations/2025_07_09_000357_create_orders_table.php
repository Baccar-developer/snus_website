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
            $table->id();
            $table->string('product_name',20);
            $table->unsignedbigInteger('quantity');
            $table->double('order_price' , 3,3);
            $table->string('governorate' , 20);
            $table->string('location' , 50);
            $table->enum("state", ["delivered" ,"canceled","unfulfilled"]);
            $table->dateTime("delivered_at")->nullable(true);
            
            $table->timestamps();
            $table->foreign('product_name')
            ->references('name')
            ->on('products')
            ->onDelete('no action');
            $table->string('tel', 8);
            $table->boolean('payed');
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
