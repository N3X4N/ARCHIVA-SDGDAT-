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
            $table->foreignId('entidad_remitente_id')
                ->constrained('dependencias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('entidad_productora_id')
                ->constrained('dependencias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->foreignId('oficina_productora_id')
                ->constrained('dependencias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('unidad_administrativa')->nullable(); // Nombre de la entidad productora
            $table->date('registro_entrada')->nullable();  // Fecha de registro de entrada
            $table->unsignedBigInteger('numero_transferencia')
                ->nullable()
                ->unique()
                ->comment('Se asigna automáticamente igual al id'); // Número de transferencia
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
