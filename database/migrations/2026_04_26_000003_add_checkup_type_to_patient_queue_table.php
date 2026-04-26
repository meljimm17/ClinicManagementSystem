<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_queue', function (Blueprint $table) {
            $table->foreignId('checkup_type_id')
                  ->nullable()
                  ->constrained('checkup_types')
                  ->nullOnDelete();
            $table->decimal('custom_fee', 10, 2)->nullable()->after('checkup_type_id');
        });
    }

    public function down(): void
    {
        Schema::table('patient_queue', function (Blueprint $table) {
            $table->dropForeign(['checkup_type_id']);
            $table->dropColumn(['checkup_type_id', 'custom_fee']);
        });
    }
};