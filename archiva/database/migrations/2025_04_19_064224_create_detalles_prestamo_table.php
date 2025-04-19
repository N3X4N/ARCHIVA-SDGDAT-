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
        Schema::create('detalles_prestamo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')
                ->constrained('prestamos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('transferencia_documental_id')
                ->constrained('transferencias_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('ubicacion_id')
                ->constrained('ubicaciones')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer('cantidad');
            $table->timestampTz('fecha_entregado')->nullable();
            $table->string('observaciones', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_prestamo');
    }
};
