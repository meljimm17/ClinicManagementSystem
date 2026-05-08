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
        Schema::table('medical_records', function (Blueprint $table) {
            $table->integer('patient_age')->nullable();
            $table->string('patient_gender', 20)->nullable();
            $table->string('patient_civil_status', 50)->nullable();
            $table->string('patient_contact', 30)->nullable();
            $table->text('patient_address')->nullable();
            $table->string('patient_blood_type', 10)->nullable();
            $table->decimal('patient_height', 5, 2)->nullable();
            $table->decimal('patient_weight', 5, 2)->nullable();
            $table->string('patient_philhealth', 50)->nullable();
            $table->string('patient_hmo', 100)->nullable();
            $table->string('patient_emergency_name', 100)->nullable();
            $table->string('patient_emergency_contact', 30)->nullable();
            $table->text('patient_allergies')->nullable();
            $table->text('patient_conditions')->nullable();
            $table->text('patient_medications')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn([
                'patient_age',
                'patient_gender',
                'patient_civil_status',
                'patient_contact',
                'patient_address',
                'patient_blood_type',
                'patient_height',
                'patient_weight',
                'patient_philhealth',
                'patient_hmo',
                'patient_emergency_name',
                'patient_emergency_contact',
                'patient_allergies',
                'patient_conditions',
                'patient_medications',
            ]);
        });
    }
};
