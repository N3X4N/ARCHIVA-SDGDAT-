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
        Schema::create('series_documentales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serie_padre_id')
                ->nullable()
                ->constrained('series_documentales')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('codigo', 20);
            $table->string('nombre', 150)->unique();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('series_documentales');
    }
};
