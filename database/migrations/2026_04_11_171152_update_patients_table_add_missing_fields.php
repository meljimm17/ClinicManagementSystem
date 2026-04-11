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
    Schema::table('patients', function (Blueprint $table) {

        if (!Schema::hasColumn('patients', 'date_of_birth')) {
            $table->date('date_of_birth')->nullable()->after('name');
        }

        if (!Schema::hasColumn('patients', 'civil_status')) {
            $table->string('civil_status')->nullable()->after('gender');
        }

        if (!Schema::hasColumn('patients', 'philhealth_no')) {
            $table->string('philhealth_no')->nullable();
        }

        if (!Schema::hasColumn('patients', 'hmo_insurance')) {
            $table->string('hmo_insurance')->nullable();
        }

        if (!Schema::hasColumn('patients', 'emergency_contact_name')) {
            $table->string('emergency_contact_name')->nullable();
        }

        if (!Schema::hasColumn('patients', 'emergency_contact_number')) {
            $table->string('emergency_contact_number')->nullable();
        }

        if (!Schema::hasColumn('patients', 'known_allergies')) {
            $table->string('known_allergies')->nullable();
        }

        if (!Schema::hasColumn('patients', 'existing_conditions')) {
            $table->string('existing_conditions')->nullable();
        }

        if (!Schema::hasColumn('patients', 'current_medications')) {
            $table->string('current_medications')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
