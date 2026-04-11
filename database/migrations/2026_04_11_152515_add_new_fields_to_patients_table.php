<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {

            // Personal
            $table->date('date_of_birth')->nullable()->after('name');
            $table->enum('civil_status', ['Single','Married','Widowed','Separated'])
                  ->nullable()->after('gender');

            // Make age nullable since DOB now covers it
            $table->unsignedTinyInteger('age')->nullable()->change();

            // Administrative
            $table->string('philhealth_number', 30)->nullable()->after('address');
            $table->string('hmo_insurance', 100)->nullable()->after('philhealth_number');
            $table->string('emergency_contact_name', 100)->nullable()->after('hmo_insurance');
            $table->string('emergency_contact_number', 20)->nullable()->after('emergency_contact_name');

            // Medical history
            $table->text('known_allergies')->nullable()->after('emergency_contact_number');
            $table->text('existing_conditions')->nullable()->after('known_allergies');
            $table->text('current_medications')->nullable()->after('existing_conditions');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'civil_status',
                'philhealth_number',
                'hmo_insurance',
                'emergency_contact_name',
                'emergency_contact_number',
                'known_allergies',
                'existing_conditions',
                'current_medications',
            ]);
        });
    }
};