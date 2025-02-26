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
        Schema::create('test_sales_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->date('sale_date');
            $table->integer('total_quantity')->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method');
            $table->decimal('payment');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_sales_masters');
    }
};
