<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mfa_codigos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->string('codigo', 6);
            $table->tinyInteger('factor'); // 1, 2 o 3
            $table->boolean('usado')->default(false);
            $table->timestamp('expira_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mfa_codigos');
    }
};