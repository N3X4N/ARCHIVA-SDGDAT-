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
        Schema::table('users', function (Blueprint $table) {
            // Agregamos la columna role_id después de la columna id (puedes ubicarla donde prefieras)
            $table->unsignedBigInteger('role_id')->nullable()->after('id');

            // Establecemos la llave foránea que referencia la tabla roles
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Primero eliminamos la llave foránea
            $table->dropForeign(['role_id']);
            // Luego eliminamos la columna
            $table->dropColumn('role_id');
        });
    }
};
