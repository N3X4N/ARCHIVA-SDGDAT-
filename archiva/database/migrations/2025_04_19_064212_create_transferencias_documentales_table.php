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
            $table->foreignId('ubicacion_id')
                ->constrained('ubicaciones')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('entidad_productora')->nullable();  // Nombre de la entidad productora
            $table->string('unidad_administrativa')->nullable();  // Nombre de la unidad administrativa
            $table->string('oficina_productora')->nullable();  // Nombre de la oficina productora
            $table->date('registro_entrada')->nullable();  // Fecha de registro de entrada
            $table->string('numero_transferencia', 30)->nullable();  // Número de transferencia
            $table->text('objeto')->nullable();  // Descripción o objeto de la transferencia
            $table->string('estado_flujo', 30)->default('ELABORADO');  // Estado de flujo, por defecto 'ingreso'
            $table->boolean('is_active')->default(true);  // Estado activo
            $table->timestamps();  // Timestamps (created_at, updated_at)
            $table->softDeletes();  // Soporte para eliminación suave (soft deletes)
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
