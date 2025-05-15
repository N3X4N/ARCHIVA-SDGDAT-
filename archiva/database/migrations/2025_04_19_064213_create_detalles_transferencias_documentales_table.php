<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalles_transferencias_documentales', function (Blueprint $table) {
            $table->id();  // ID único para cada detalle
            $table->foreignId('transferencia_id')  // Relación con la transferencia principal
                ->constrained('transferencias_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('ubicacion_id')  // Relaciona con la tabla 'ubicaciones'
                ->nullable()
                ->constrained('ubicaciones')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            // Otros campos
            $table->string('numero_orden', 30)->nullable();  // Número de orden del documento
            // Aquí reemplazamos el string 'codigo' manual por un FK y lo generamos en el controller
            $table->string('codigo', 60)->nullable(); // Código del documento
            // FKs a Serie y Subserie
            $table->foreignId('serie_documental_id')
                ->constrained('series_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // En lugar de usar constrained() automático:
            $table->foreignId('subserie_documental_id')
                ->nullable();
            $table->foreign('subserie_documental_id', 'fk_dt_subserie')  // nombre corto
                ->references('id')
                ->on('subseries_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('fecha_inicial')->nullable();  // Fecha inicial
            $table->date('fecha_final')->nullable();  // Fecha final
            $table->integer('caja')->nullable();  // Número de caja
            $table->integer('carpeta')->nullable();  // Número de carpeta
            $table->integer('resolucion')->nullable();  // Número de resolución
            $table->integer('tomo')->nullable();  // Número de tomo
            $table->integer('otro')->nullable();  // Otro campo adicional
            $table->integer('numero_folios')->nullable();  // Número de folios
            $table->string('soporte')->nullable();  // Tipo de soporte (papel, digital, etc.)
            $table->string('frecuencia_consulta')->nullable();  // Frecuencia de consulta
            $table->string('ubicacion_caja')->nullable();  // Ubicación de la caja
            $table->string('ubicacion_bandeja')->nullable();  // Ubicación de la bandeja
            $table->string('ubicacion_estante')->nullable();  // Ubicación del estante
            $table->text('observaciones')->nullable();  // Observaciones adicionales
            $table->string('estado_flujo', 30)->default('Activo'); // Estado de flujo, por defecto 'ingreso'
            $table->timestamps();  // Timestamps (created_at, updated_at)
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_transferencias_documentales');
    }
};
