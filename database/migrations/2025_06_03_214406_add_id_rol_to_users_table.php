<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * ✅ ALTER
     * La migración add_is_admin_and_id_rol_to_users que creaste es una migración de tipo ALTER, es decir, modifica la tabla users ya existente, y no la crea desde cero.
     */
    public function up(): void
    {
        // esta tabla agrega a users : is_admin y id_rol
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rol')->nullable();
            $table->foreign('id_rol')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esto permite eliminar correctamente
        // Se deshagan correctamente los cambios y la tabla users vuelva a su estado original.
        // php artisan migrate:rollback
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_rol']); // Elimina la FK primero
            $table->dropColumn('id_rol');
        });
    }
};
