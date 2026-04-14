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
        if (! Schema::hasColumn('doctors', 'user_id')) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        }

        if (! Schema::hasColumn('doctors', 'assigned_room')) {
            $table->string('assigned_room')->nullable()->after('license_number');
        }
    });
}

public function down(): void
{
    Schema::table('doctors', function (Blueprint $table) {
        if (Schema::hasColumn('doctors', 'user_id')) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        }

        if (Schema::hasColumn('doctors', 'assigned_room')) {
            $table->dropColumn('assigned_room');
        }
    });
}
};
