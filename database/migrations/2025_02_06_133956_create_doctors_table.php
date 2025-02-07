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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('specialization');
            $table->string('license_number')->unique();
            $table->text('address')->nullable();
            $table->string('gender');
            $table->date('dob')->nullable(); // Date of Birth
            $table->decimal('consultation_fee', 10, 2);
            $table->text('experience'); // Years of experience or details
            $table->string('availability_status')->default('active'); // active, inactive
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
        Schema::dropIfExists('doctors');
    }
};
