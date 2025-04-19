<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias_documentales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('dependencia_id')
                ->constrained('dependencias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('serie_documental_id')
                ->constrained('series_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('subserie_documental_id')
                ->constrained('subseries_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('ubicacion_id')
                ->constrained('ubicaciones')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Metadatos de la transferencia
            $table->string('oficina_productora', 150)->nullable();
            $table->date('registro_entrada')->nullable();
            $table->string('numero_transferencia', 30)->nullable();
            $table->text('objeto')->nullable();
            $table->string('numero_orden', 30)->nullable();
            $table->string('codigo_interno', 30)->nullable();
            $table->date('fecha_extrema_inicial')->nullable();
            $table->date('fecha_extrema_final')->nullable();
            $table->integer('numero_folios')->nullable();
            $table->string('soporte', 50)->nullable();
            $table->string('frecuencia_consulta', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->string('estado_flujo', 30)->default('ingreso');

            $table->boolean('is_active')->default(true);
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transferencias_documentales');
    }
};
