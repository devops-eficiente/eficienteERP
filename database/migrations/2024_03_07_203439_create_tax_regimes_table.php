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
        Schema::create( 'tax_regimes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('Codigo de regimen');
            $table->string('name')->comment('Nombre de regimen');
            $table->string('start_date')->comment('Fecha de inicio de vigencia');
            $table->boolean('moral')->comment('Aplica para Moral');
            $table->boolean('fisica')->comment('Aplica para Fisica');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_regimes');
    }
};
