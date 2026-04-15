<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_queue_priorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_queue_id')->unique()->constrained('patient_queue')->cascadeOnDelete();
            $table->string('priority_type', 30);
            $table->string('notes', 255)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_queue_priorities');
    }
};
