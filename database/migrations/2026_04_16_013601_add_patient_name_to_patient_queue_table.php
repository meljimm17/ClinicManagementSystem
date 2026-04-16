<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('patient_queue', 'patient_name')) {
            Schema::table('patient_queue', function (Blueprint $table) {
                $table->string('patient_name')->nullable()->after('patient_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('patient_queue', 'patient_name')) {
            Schema::table('patient_queue', function (Blueprint $table) {
                $table->dropColumn('patient_name');
            });
        }
    }
};
