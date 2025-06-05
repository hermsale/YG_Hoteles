<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitacionImagenTable extends Migration
{
    public function up()
    {
        Schema::create('habitacion_imagen', function (Blueprint $table) {
            $table->foreignId('id_habitacion')->constrained('habitaciones')->onDelete('cascade');
            $table->foreignId('id_imagen')->constrained('imagenes')->onDelete('restrict');

            $table->primary(['id_habitacion', 'id_imagen']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('habitacion_imagen');
    }
}
