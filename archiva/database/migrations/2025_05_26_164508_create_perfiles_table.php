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
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('dependencia_id')
                ->nullable()
                ->constrained('dependencias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nombres', 150);
            $table->string('apellidos', 150);
            $table->text('firma_digital')->nullable(); // base64 o ruta de archivo

            $table->timestampsTz();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfiles');
    }
};
