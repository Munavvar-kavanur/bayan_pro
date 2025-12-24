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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('status')->default('draft'); // draft, sent, accepted, rejected
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->string('discount_type')->default('fixed'); // fixed, percent
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
