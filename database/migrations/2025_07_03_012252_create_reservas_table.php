<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ingreso');
            $table->date('fecha_egreso');
            $table->decimal('precio_final', 10, 2);
            $table->string('estado_pago')->default('Pendiente');
            $table->string('estado_reserva');
            $table->timestamp('fecha_creacion')->useCurrent();

            $table->foreignId('id_habitacion')->constrained('habitaciones')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_promocion')->nullable()->constrained('promociones')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}
