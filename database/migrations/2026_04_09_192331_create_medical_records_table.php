<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name'); // Permanent snapshot of the name
            $table->foreignId('queue_id')
                  ->nullable()
                  ->constrained('patient_queue')
                  ->nullOnDelete();
            $table->foreignId('patient_id')
                  ->constrained('patients')
                  ->cascadeOnDelete();
            $table->foreignId('doctor_id')
                  ->nullable()
                  ->constrained('doctors')
                  ->nullOnDelete();
            $table->text('symptoms')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('assigned_room', 50)->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->date('consultation_date');
            $table->time('consultation_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};