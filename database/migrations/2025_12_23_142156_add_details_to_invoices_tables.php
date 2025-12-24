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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(0)->after('total_amount');
            $table->string('discount_type')->default('fixed')->after('tax_rate'); // 'fixed' or 'percent'
            $table->decimal('discount_value', 10, 2)->default(0)->after('discount_type');
        });

        Schema::table('invoice_items', function (Blueprint $table) {
            $table->string('title')->nullable()->after('invoice_id');
            $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices_tables', function (Blueprint $table) {
            //
        });
    }
};
