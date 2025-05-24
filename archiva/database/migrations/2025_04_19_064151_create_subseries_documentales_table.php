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
        Schema::create('subseries_documentales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serie_documental_id')
                ->constrained('series_documentales')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->string('codigo', 20);
            $table->string('nombre', 150);
            $table->boolean('is_active')->default(true);
            $table->timestampsTz();
            $table->softDeletesTz();

            // Evita duplicar código dentro de la misma serie
            $table->unique(['serie_documental_id', 'codigo']);
            // Evita duplicar nombre dentro de la misma serie
            $table->unique(['serie_documental_id', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subseries_documentales');
    }
};
