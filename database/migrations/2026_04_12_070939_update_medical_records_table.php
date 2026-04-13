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
        if (!Schema::hasColumn('medical_records', 'prescription')) {
            $table->text('prescription')->after('diagnosis')->nullable();
        }
        if (!Schema::hasColumn('medical_records', 'notes')) {
            $table->text('notes')->after('prescription')->nullable();
        }
        if (!Schema::hasColumn('medical_records', 'record_status')) {
            $table->string('record_status')->after('notes')->default('completed');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            //
        });
    }
};
