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
        Schema::create('test_sales_details', function (Blueprint $table) {
            $table->id();
            $table->integer('test_sale_master_id');
            $table->integer('test_id');
            $table->decimal('price');
            $table->integer('quantity');
            $table->decimal('total', 10, 2);
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
        Schema::dropIfExists('test_sales_details');
    }
};
