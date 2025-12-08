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
        Schema::create('resource', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock');
            $table->string('description');
            $table->timestamp('date_expired')->nullable();
            $table->string('active_num');
            $table->string('serial_num');

            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('ubication_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('extend_id');
            $table->unsignedBigInteger('material_id');
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->foreign('ubication_id')->references('id')->on('ubication');
            $table->foreign('type_id')->references('id')->on('type');
            $table->foreign('extend_id')->references('id')->on('extend');
            $table->foreign('material_id')->references('id')->on('material');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource');
    }
};
