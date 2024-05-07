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
        Schema::create('person_tax_regime', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained('persons','id')->comment('Id persona');
            $table->foreignId('tax_regime_id')->constrained()->comment('Id regimen fiscal');
            $table->date('start_date')->nullable()->comment('Fecha de inicio');
            $table->date('end_date')->nullable()->comment('Fecha de fin');
            $table->boolean('status')->nullable()->comment('Estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_tax_regime');
    }
};
