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
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('descripcion', 255);
            $table->integer('capacidad');
            $table->integer('codigo_habitacion');
            $table->decimal('precio_noche', 10, 2);
            $table->string('estado', 10)->default('Activo');
            $table->foreignId('id_categoria')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
        });

        // Sobreescribimos el tipo de columna para que use el ENUM nativo de PostgreSQL
        DB::statement("ALTER TABLE habitaciones ALTER COLUMN estado DROP DEFAULT");
        DB::statement("ALTER TABLE habitaciones ALTER COLUMN estado TYPE estado_habitacion_enum USING estado::text::estado_habitacion_enum");
        DB::statement("ALTER TABLE habitaciones ALTER COLUMN estado SET DEFAULT 'Activo'::estado_habitacion_enum");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitaciones');
    }
};
