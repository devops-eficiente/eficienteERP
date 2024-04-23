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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('n_employee')->comment('IdEmpleado');
            $table->string('paternal_surname')->comment('Apellido paterno');
            $table->string('maternal_surname')->comment('Apellido materno');
            $table->string('name')->comment('Nombre');
            $table->string('zip_code',5)->nullable()->comment('Codigo Postal');
            $table->string('curp')->comment('CURP Empleado');
            $table->string('rfc')->comment('RFC Empleado');
            $table->foreignId('institute_health_id')->nullable()->constrained()->comment('Instituto de salud');
            $table->string('nss')->comment('NSS Empleado');
            $table->foreignId('identification_employee_id')->nullable()->constrained()->comment('Identificacion');
            $table->string('n_identification')->comment('Numero de identificacion');
            $table->enum('gender',['Hombre','Mujer','Otro'])->default('Otro');
            $table->enum('nationality',['Mexicana','Extrangera'])->default('Mexicana');
            $table->date('birthdate')->comment('Fecha de nacimiento');
            $table->json('contacts')->comment('Medios de contacto');
            $table->json('emergency_contacts')->comment('Medios de contacto');
            $table->foreignId('blood_type_id')->nullable()->constrained()->comment('Tipo de sangre');
            $table->foreignId('marital_status_id')->nullable()->constrained('marital_status')->comment('Estado civil');
            $table->boolean('rfc_verified')->default(0)->comment('Verificación RFC');
            $table->boolean('complete')->default(0)->comment('Perfil completo');
            $table->json('rfc_data')->nullable()->comment('Respuesta archivo RFC');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
