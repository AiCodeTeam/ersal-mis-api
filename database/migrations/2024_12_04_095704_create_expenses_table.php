<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('details');
            $table->double('price');
            $table->date('date');
            $table->unsignedBigInteger('expense_categories_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('purchased_by');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('expense_categories_id')->references('id')->on('expense_categories')->nullOnDelete()->nullOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->nullOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
