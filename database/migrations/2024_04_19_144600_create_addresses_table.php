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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->comment('Id cliente');
            $table->string('zip_code',5)->comment('Codigo postal');
            $table->string('road_type')->comment('Tipo de vialidad');
            $table->string('road_name')->comment('Nombre de vialidad');
            $table->string('internal_number')->comment('Número interno de la dirección del cliente');
            $table->string('external_number')->comment('Número externo de la dirección del cliente');
            $table->string('suburb')->comment('Colonia de la dirección del cliente');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
