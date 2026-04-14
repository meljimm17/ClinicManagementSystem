<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Backfill null queue_date from queued_at/created_at before enforcing NOT NULL.
        DB::statement("
            UPDATE patient_queue
            SET queue_date = DATE(COALESCE(queued_at, created_at))
            WHERE queue_date IS NULL
        ");

        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("
                ALTER TABLE patient_queue
                MODIFY queue_date DATE NOT NULL
            ");
        } elseif ($driver === 'pgsql') {
            DB::statement("
                ALTER TABLE patient_queue
                ALTER COLUMN queue_date SET NOT NULL
            ");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("
                ALTER TABLE patient_queue
                MODIFY queue_date DATE NULL
            ");
        } elseif ($driver === 'pgsql') {
            DB::statement("
                ALTER TABLE patient_queue
                ALTER COLUMN queue_date DROP NOT NULL
            ");
        }
    }
};
