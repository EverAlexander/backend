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
        Schema::create('movement_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('quanty');
            $table->double('unit_cost');
            $table->double('sub_total_item');

            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('movement_id');
            $table->foreign('resource_id')->references('id')->on('resource');
            $table->foreign('movement_id')->references('id')->on('movement');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_detail');
    }
};
