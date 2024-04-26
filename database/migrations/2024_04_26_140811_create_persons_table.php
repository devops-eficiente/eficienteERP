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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('rfc')->comment('RFC Empleado');
            $table->enum('type',['employee','client'])->comment('Cliente o Empleado');
            $table->enum('regimen',['fiscal','moral'])->comment('Tipo de regimen');
            $table->date('start_date')->comment('Fecha de inicio de operaciones');
            $table->string('status')->comment('Estado del padron');
            $table->string('comments')->nullable()->comment('Comentarios del SAT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
