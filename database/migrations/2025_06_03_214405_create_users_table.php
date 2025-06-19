<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// las migraciones nos permite tener un control de versiones de la estructura de datos
return new class extends Migration
{
    /**
     * en el metodo up, se define que que hará la migracion. Por ejemplo
     * la creación e información que tendrá una tabla nueva
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); //por defecto se genera una columna autoincremental que funciona como clave primaria de la tabla
            $table->string('name',100);
            $table->string('email',150)->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            // $table->foreignId(column: 'id_rol')->constrained('roles')->onDelete('cascade'); // esto lo agrego en el id_rol_to_users
            // $table->rememberToken();
            $table->timestamps(); // Genera dos columnas, una para guardar la fecha y hora en que se generó un registro y otra la modificación del mismo.
        });

        // Schema::create('password_reset_tokens', function (Blueprint $table) {
        //     $table->string('email')->primary();
        //     $table->string('token');
        //     $table->timestamp('created_at')->nullable();
        // });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * en el metodo down, especificamos que tiene que hacer para volver un paso atras
     * ejemplo, eliminar la tabla que creamos en up
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        // Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
