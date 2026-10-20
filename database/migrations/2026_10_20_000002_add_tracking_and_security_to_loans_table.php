<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->date('due_date')->nullable()->after('duration_months');
            $table->decimal('penalty_amount', 12, 2)->default(0)->after('balance');
            $table->text('collateral_description')->nullable()->after('penalty_amount');
            $table->decimal('collateral_value', 14, 2)->nullable()->after('collateral_description');
            $table->string('guarantor_name')->nullable()->after('collateral_value');
            $table->string('guarantor_contact')->nullable()->after('guarantor_name');
            $table->string('guarantor_nin')->nullable()->after('guarantor_contact');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn([
                'due_date',
                'penalty_amount',
                'collateral_description',
                'collateral_value',
                'guarantor_name',
                'guarantor_contact',
                'guarantor_nin',
            ]);
        });
    }
};
