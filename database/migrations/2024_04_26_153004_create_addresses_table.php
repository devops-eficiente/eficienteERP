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
            $table->foreignId('person_id')->constrained('persons','id')->comment('Id persona');
            $table->string('state')->nullable()->comment('Estado asociado');
            $table->string('city')->nullable()->comment('Municipio asociado');
            $table->string('zip_code',5)->nullable()->comment('Codigo postal');
            $table->string('road_type')->nullable()->comment('Tipo de vialidad');
            $table->string('road_name')->nullable()->comment('Nombre de vialidad');
            $table->string('internal_number')->nullable()->comment('Número interno de la dirección del cliente');
            $table->string('external_number')->nullable()->comment('Número externo de la dirección del cliente');
            $table->string('suburb')->nullable()->comment('Colonia de la dirección del cliente');
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
