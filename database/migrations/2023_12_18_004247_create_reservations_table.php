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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('renter_name');
            $table->string('renter_last_name');
            $table->string('email_address');
            $table->string('phone_number');
            $table->date('reservation_start_date');
            $table->date('reservation_end_date');
            $table->string('delivery_address');
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
        Schema::dropIfExists('reservations');
    }
};
