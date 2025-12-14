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
        Schema::create('modelo', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre_modelo');
            $table->string('descripcion_modelo')->nullable();
            $table->unsignedBigInteger('id_marca_fk');
            $table->foreign('id_marca_fk')->references('id')->on('marca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelo');
    }
};
