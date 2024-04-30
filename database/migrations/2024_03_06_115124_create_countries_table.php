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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->comment('Nombre del país');
            $table->string('iso', 8)->comment('ISO del país');
            $table->unsignedBigInteger('created_by_user_id')->nullable()->comment('Id del usuario que creó este registro');
            $table->unsignedBigInteger('updated_by_user_id')->nullable()->comment('Id del usuario que editó este registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
