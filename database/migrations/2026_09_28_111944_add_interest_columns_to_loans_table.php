<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('interest_rate', 5, 2)->default(10.00)->after('principal_amount'); // e.g. 10.00 for 10%
            $table->integer('duration_months')->default(6)->after('interest_rate');
            $table->decimal('total_payable', 15, 2)->default(0)->after('duration_months');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['interest_rate', 'duration_months', 'total_payable']);
        });
    }
};
