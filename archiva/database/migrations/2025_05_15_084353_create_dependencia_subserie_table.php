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
        Schema::create('dependencia_subserie', function (Blueprint $table) {
            $table->foreignId('dependencia_id')
                ->constrained('dependencias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('subserie_documental_id')
                ->constrained('subseries_documentales')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->primary(['dependencia_id', 'subserie_documental_id'], 'pk_dependencia_subserie');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dependencia_subserie');
    }
};
