<?php
// database/migrations/2025_05_17_000000_add_firmas_to_transferencias_documentales.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transferencias_documentales', function (Blueprint $table) {
            // Quién elaboró y cuándo
            $table->foreignId('elaborado_por')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->after('objeto');
            $table->timestamp('elaborado_fecha')
                ->nullable()
                ->after('elaborado_por');

            // Quién entregó y cuándo
            $table->foreignId('entregado_por')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->after('elaborado_fecha');
            $table->timestamp('entregado_fecha')
                ->nullable()
                ->after('entregado_por');

            // Quién recibió y cuándo
            $table->foreignId('recibido_por')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete()
                ->after('entregado_fecha');
            $table->timestamp('recibido_fecha')
                ->nullable()
                ->after('recibido_por');
        });
    }

    public function down()
    {
        Schema::table('transferencias_documentales', function (Blueprint $table) {
            $table->dropForeign(['elaborado_por']);
            $table->dropForeign(['entregado_por']);
            $table->dropForeign(['recibido_por']);
            $table->dropColumn([
                'elaborado_por',
                'elaborado_fecha',
                'entregado_por',
                'entregado_fecha',
                'recibido_por',
                'recibido_fecha',
            ]);
        });
    }
};
