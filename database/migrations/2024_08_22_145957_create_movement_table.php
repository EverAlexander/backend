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
        Schema::create('movement', function (Blueprint $table) {
            $table->id();
            $table->string('num_invoice');
            $table->double('total_cost');
            $table->string('description');
            $table->string('observation');
            $table->string('movement_type');
            $table->timestamp('date_movement')->nullable();

            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('supplier_id')->references('id')->on('supplier');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement');
    }
};
