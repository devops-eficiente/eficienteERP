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
            $table->string('n_client')->comment('ID Cliente');
            $table->foreignId('person_id')->constrained('persons','id')->comment('Id persona');
            $table->foreignId('capital_regime_id')->nullable()->constrained()->comment('Id Regimen de capital');
            $table->string('company_name')->comment('Razon social');
            $table->boolean('status')->comment('Estado del cliente');
            $table->date('updated_date')->nullable()->comment('Fecha de último cambio de estado');
            $table->boolean('rfc_verified')->default(0)->comment('RFC VERIFICADO');
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
