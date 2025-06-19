<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitacionAmenityTable extends Migration
{

    public function up()
    {
        Schema::create('habitacion_amenity', function (Blueprint $table) {
            $table->foreignId('id_habitacion')->constrained('habitaciones')->onDelete('cascade');
            $table->foreignId('id_amenity')->constrained('amenities')->onDelete('cascade');
            $table->primary(['id_habitacion', 'id_amenity']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('habitacion_amenity');
    }
}
