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
    Schema::create('transaccion_cajas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cierre_caja_id')->constrained('cierre_cajas')->onDelete('cascade');
        $table->string('concepto');
        $table->string('cliente')->nullable();
        $table->decimal('monto', 10, 2);
        $table->foreignId('metodo_pago_id')->constrained('metodo_pago');
        $table->text('comentario')->nullable();
        $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaccion_cajas');

    }
};
