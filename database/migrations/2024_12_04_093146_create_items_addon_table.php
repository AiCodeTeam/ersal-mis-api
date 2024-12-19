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
        Schema::create('items_addon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('description');
            $table->integer('price_usd');
            $table->integer('price_afg');
            $table->integer('quantity');
            $table->string('bill_image');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
    
            $table->foreign('item_id')->references('id')->on('items')->nullOnDelete()->nullOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_addon');
    }
};
