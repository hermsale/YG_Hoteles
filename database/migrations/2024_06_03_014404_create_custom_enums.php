<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCustomEnums extends Migration
{
    public function up()
    {

        // agrego a la migracion los enum correspondientes al estado de la habitacion
        DB::statement("
            DO \$\$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_habitacion_enum') THEN
                    CREATE TYPE estado_habitacion_enum AS ENUM ('Activo', 'Inactivo');
                END IF;
            END \$\$;
        ");
        // con el DB::statement obligo a laravel a usar el esquema de la base de datos de los enums
        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_pago_enum') THEN
                    CREATE TYPE estado_pago_enum AS ENUM ('Pendiente', 'Pagado', 'Cancelado');
                END IF;
            END $$;
        ");

        DB::statement("
            DO $$ BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_reserva_enum') THEN
                    CREATE TYPE estado_reserva_enum AS ENUM ('Activa', 'Pendiente', 'Finalizada', 'Cancelada');
                END IF;
            END $$;
        ");


    }

    public function down()
    {
        DB::statement("DROP TYPE IF EXISTS estado_habitacion_enum");
        DB::statement("DROP TYPE IF EXISTS estado_pago_enum");
        DB::statement("DROP TYPE IF EXISTS estado_reserva_enum");
    }
}
