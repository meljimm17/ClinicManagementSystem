<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->text('prescription')->nullable()->after('diagnosis');
            $table->text('notes')->nullable()->after('prescription');
            $table->enum('record_status', ['draft', 'held_for_labs', 'completed'])
                  ->default('draft')->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['prescription', 'notes', 'record_status']);
        });
    }
};