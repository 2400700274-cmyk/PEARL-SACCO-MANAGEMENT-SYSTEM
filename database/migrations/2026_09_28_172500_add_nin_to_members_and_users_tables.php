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
        Schema::table('members', function (Blueprint $table) {
            $table->string('nin')->nullable()->after('name');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('nin')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('nin');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nin');
        });
    }
};
