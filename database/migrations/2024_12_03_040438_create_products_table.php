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
            $table->string('name');
            $table->integer('price');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->string('quantity');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            // Add foreign key constraint if there's a Category table
            $table->foreign('product_category_id')->references('id')->on('categories')->nullOnDelete()->nullOnUpdate();
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
