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
        Schema::create('capital_regimes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del regimen de capital');
            $table->string('acronym')->comment('Abreviación del regimen de capital');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capital_regimes');
    }
};
