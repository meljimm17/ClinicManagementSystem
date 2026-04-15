<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_snapshots', function (Blueprint $table) {
            $table->id();
            $table->date('snapshot_date')->unique();
            $table->unsignedInteger('total_patients')->default(0);
            $table->unsignedInteger('total_consultations')->default(0);
            $table->unsignedInteger('records_filed')->default(0);
            $table->decimal('avg_wait_minutes', 8, 2)->nullable();
            $table->json('top_diagnoses')->nullable();
            $table->json('doctor_stats')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_snapshots');
    }
};
