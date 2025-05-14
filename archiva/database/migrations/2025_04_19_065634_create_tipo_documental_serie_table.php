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
        Schema::create('tipo_documental_serie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documental_id')
                ->constrained('tipos_documentales')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('serie_documental_id')
                ->constrained('series_documentales')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestampsTz();
            $table->unique(['tipo_documental_id', 'serie_documental_id'], 'uk_td_serie');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_documental_serie');
    }
};
