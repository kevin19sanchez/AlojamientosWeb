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
        Schema::create('alojamientos', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('ubicacion');
            $table->text('precio');
            $table->text('descripcion');
            $table->text('cpacidad');
            $table->unsignedBigInteger('id_tipo_alojamiento');
            $table->text('imagen');
            $table->foreign('id_tipo_alojamiento')->references('id')->on('tipos_alojamientos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alojamientos');
    }
};
