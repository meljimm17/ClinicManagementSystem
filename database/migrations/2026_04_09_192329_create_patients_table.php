<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('contact_number', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('height', 20)->nullable();
            $table->string('weight', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};