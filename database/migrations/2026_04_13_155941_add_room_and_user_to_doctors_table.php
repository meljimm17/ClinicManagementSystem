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
        $table->unsignedBigInteger('user_id')->nullable()->after('id');
        $table->string('assigned_room')->nullable()->after('license_number');

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('doctors', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['user_id', 'assigned_room']);
    });
}
};
