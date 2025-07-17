<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cierre_cajas', function (Blueprint $table) {
        $table->id();
        $table->date('fecha')->unique(); // Un cierre por día
        $table->decimal('total', 10, 2);
        $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('cierre_cajas');
    }
};
