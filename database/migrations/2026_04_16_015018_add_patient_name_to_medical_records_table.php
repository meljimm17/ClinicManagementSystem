<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('medical_records', 'patient_name')) {
            Schema::table('medical_records', function (Blueprint $table) {
                $table->string('patient_name')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('medical_records', 'patient_name')) {
            Schema::table('medical_records', function (Blueprint $table) {
                $table->dropColumn('patient_name');
            });
        }
    }
};