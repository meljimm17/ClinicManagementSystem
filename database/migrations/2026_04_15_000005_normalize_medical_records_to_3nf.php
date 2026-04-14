<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure one record per queue entry before adding UNIQUE.
        $duplicates = DB::table('medical_records')
            ->select('queue_id', DB::raw('MIN(id) as keep_id'))
            ->whereNotNull('queue_id')
            ->groupBy('queue_id')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('medical_records')
                ->where('queue_id', $duplicate->queue_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'queue_id')) {
                $table->dropForeign(['queue_id']);
            }

            if (Schema::hasColumn('medical_records', 'patient_id')) {
                $table->dropForeign(['patient_id']);
            }
        });

        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'patient_id')) {
                $table->dropColumn('patient_id');
            }

            if (Schema::hasColumn('medical_records', 'duration_minutes')) {
                $table->dropColumn('duration_minutes');
            }
        });

        $driver = DB::getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE medical_records MODIFY queue_id BIGINT UNSIGNED NOT NULL");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE medical_records ALTER COLUMN queue_id SET NOT NULL");
        }

        Schema::table('medical_records', function (Blueprint $table) {
            $table->unique('queue_id');
            $table->foreign('queue_id')->references('id')->on('patient_queue')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropForeign(['queue_id']);
            $table->dropUnique(['queue_id']);
        });

        $driver = DB::getDriverName();
        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement("ALTER TABLE medical_records MODIFY queue_id BIGINT UNSIGNED NULL");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE medical_records ALTER COLUMN queue_id DROP NOT NULL");
        }

        Schema::table('medical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_records', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('queue_id');
                $table->foreign('patient_id')->references('id')->on('patients')->nullOnDelete();
            }

            if (!Schema::hasColumn('medical_records', 'duration_minutes')) {
                $table->unsignedSmallInteger('duration_minutes')->nullable()->after('record_status');
            }

            $table->foreign('queue_id')->references('id')->on('patient_queue')->nullOnDelete();
        });
    }
};
