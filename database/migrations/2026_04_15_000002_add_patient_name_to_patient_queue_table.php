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
            if (!Schema::hasColumn('patient_queue', 'patient_name')) {
                $table->string('patient_name')->nullable()->after('patient_id');
            }
        });

        DB::table('patient_queue')
            ->whereNull('patient_name')
            ->whereNotNull('patient_id')
            ->orderBy('id')
            ->get(['id', 'patient_id'])
            ->each(function ($queue) {
                $name = DB::table('patients')
                    ->where('id', $queue->patient_id)
                    ->value('name');

                if ($name !== null) {
                    DB::table('patient_queue')
                        ->where('id', $queue->id)
                        ->update(['patient_name' => $name]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('patient_queue', function (Blueprint $table) {
            if (Schema::hasColumn('patient_queue', 'patient_name')) {
                $table->dropColumn('patient_name');
            }
        });
    }
};
