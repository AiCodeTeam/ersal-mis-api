<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('quantity');
            $table->date('date');
            $table->double('price_usa');
            $table->double('price_afn');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete()->nullOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->nullOnUpdate();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete()->nullOnUpdate();
            $table->foreign('item_id')->references('id')->on('items')->nullOnDelete()->nullOnUpdate();
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
