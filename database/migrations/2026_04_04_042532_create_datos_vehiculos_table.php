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
        Schema::create('datos_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribuidor_id')->constrained('distribuidoras')->onDelete('cascade');
            $table->string('marca');
            $table->string('modelo');
            $table->string('color');
            $table->string('numero_placas')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_datos_vehiculos');
    }
};
