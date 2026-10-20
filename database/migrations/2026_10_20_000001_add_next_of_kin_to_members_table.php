<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('next_of_kin_name')->nullable()->after('contact');
            $table->string('next_of_kin_contact')->nullable()->after('next_of_kin_name');
            $table->string('next_of_kin_relationship')->nullable()->after('next_of_kin_contact');
            $table->string('next_of_kin_address')->nullable()->after('next_of_kin_relationship');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'next_of_kin_name',
                'next_of_kin_contact',
                'next_of_kin_relationship',
                'next_of_kin_address',
            ]);
        });
    }
};
