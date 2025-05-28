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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')
                ->constrained('roles') // tabla roles
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->boolean('is_active')->default(true);

            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
