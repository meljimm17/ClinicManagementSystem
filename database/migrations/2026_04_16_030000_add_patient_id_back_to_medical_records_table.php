<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('medical_records', 'patient_id')) {
            Schema::table('medical_records', function (Blueprint $table) {
                $table->foreignId('patient_id')
                    ->nullable()
                    ->after('queue_id')
                    ->constrained('patients')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('medical_records', 'patient_id')) {
            Schema::table('medical_records', function (Blueprint $table) {
                $table->dropForeign(['patient_id']);
                $table->dropColumn('patient_id');
            });
        }
    }
};
