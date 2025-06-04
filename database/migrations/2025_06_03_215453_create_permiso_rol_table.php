<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // ❌ No es obligatorio crear un MODELO para la tabla intermedia rol_permiso, si solo la usás como tabla pivote en relaciones muchos a muchos.
        // Ya que Laravel maneja automáticamente esa tabla cuando usás belongsToMany() en tus modelos Rol y Permiso.

        //
        // creo la tabla pivote o intermedia que une rol con permiso muchos a muchos EN LA BASE DE DATOS
        Schema::create('permiso_rol', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_permiso');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('id_permiso')->references('id')->on('permisos')->onDelete('cascade');
            $table->primary(['id_rol', 'id_permiso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_rol');
    }
};
