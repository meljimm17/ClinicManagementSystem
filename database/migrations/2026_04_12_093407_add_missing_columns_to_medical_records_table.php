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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        }
        if (! Schema::hasColumn('doctors', 'room')) {
            $table->string('room')->nullable()->after('license_number');
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
        if (Schema::hasColumn('doctors', 'room')) {
            $table->dropColumn('room');
        }
    });
}
};
