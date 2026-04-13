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
    Schema::table('doctors', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('room')->nullable()->after('license_number');
    });
}

public function down(): void
{
    Schema::table('medical_records', function (Blueprint $table) {
        $table->dropColumn(['prescription', 'notes', 'record_status']);
    });
}
};
