<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('unidade')->default('un');
            $table->unsignedInteger('quantidade')->default(0);
            $table->unsignedInteger('quantidade_minima')->default(10);
            $table->decimal('custo_unitario', 10, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
