<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();

            // Relaciones ────────────────────────────────────────────
            $table->foreignId('user_id_solicitante')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('user_id_receptor')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Fechas ────────────────────────────────────────────────
            $table->timestampTz('fecha_prestamo')->useCurrent();
            $table->timestampTz('fecha_vencimiento')->nullable();
            $table->timestampTz('fecha_devolucion')->nullable();

            // Otros campos ─────────────────────────────────────────
            $table->enum('estado', ['prestado', 'devuelto', 'vencido'])
                ->default('prestado');

            $table->text('firma_solicitante')->nullable();
            $table->text('firma_receptor')->nullable();
            $table->text('observaciones')->nullable();

            // Auditoría ────────────────────────────────────────────
            $table->boolean('is_active')->default(true);
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
