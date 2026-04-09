<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_queue', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number', 20)->unique();
            $table->foreignId('patient_id')
                  ->constrained('patients')
                  ->cascadeOnDelete();
            $table->foreignId('registered_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->text('symptoms')->nullable();
            $table->enum('status', ['waiting', 'diagnosing', 'done'])->default('waiting');
            $table->string('assigned_room', 50)->nullable();
            $table->timestamp('queued_at')->useCurrent();
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_queue');
    }
};