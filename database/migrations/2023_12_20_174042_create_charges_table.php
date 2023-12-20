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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->boolean('is_paid')->default(false); 
            $table->string('customer_id');
            $table->string('payment_id');
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
