<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_queue', function (Blueprint $table) {
            $table->dropUnique(['queue_number']);
            $table->date('queue_date')->nullable()->after('queue_number');
            $table->unique(['queue_number', 'queue_date']);
        });
    }

    public function down(): void
    {
        Schema::table('patient_queue', function (Blueprint $table) {
            $table->dropUnique(['queue_number', 'queue_date']);
            $table->dropColumn('queue_date');
            $table->unique('queue_number');
        });
    }
};