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
        if (Schema::hasTable('produto') && !Schema::hasTable('produtos')) {
            Schema::rename('produto', 'produtos');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('produtos') && !Schema::hasTable('produto')) {
            Schema::rename('produtos', 'produto');
        }
    }
};
