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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->comment('Razon social');
            $table->string('capital_regime')->comment('Regimen de capital');
            $table->string('rfc')->comment('RFC de la empresa');
            $table->date('start_date')->comment('Fecha de inicio de operaciones');
            $table->boolean('status')->comment('Estado del padron');
            $table->date('updated_date')->comment('Fecha de último cambio de estado');
            $table->json('path_cif')->comment('Respuesta JSON');
            $table->string('state')->comment('Estado asociado');
            $table->string('city')->comment('Municipio asociado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
