<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_records', 'doctor_name')) {
                $table->string('doctor_name')->nullable()->after('doctor_id');
            }
            if (!Schema::hasColumn('medical_records', 'assigned_room')) {
                $table->string('assigned_room')->nullable()->after('doctor_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            if (Schema::hasColumn('medical_records', 'doctor_name')) {
                $table->dropColumn('doctor_name');
            }
            if (Schema::hasColumn('medical_records', 'assigned_room')) {
                $table->dropColumn('assigned_room');
            }
        });
    }
};