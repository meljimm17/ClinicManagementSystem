<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->after('username');
            }

            if (!Schema::hasColumn('users', 'contact_number')) {
                $table->string('contact_number', 30)->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('contact_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('users', 'contact_number')) {
                $table->dropColumn('contact_number');
            }

            if (Schema::hasColumn('users', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
