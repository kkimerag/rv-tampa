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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_nightly_price', 8, 2);
            $table->integer('minimum_stay');
            $table->integer('maximum_stay');
            $table->decimal('deposit', 8, 2);
            $table->integer('over_week_discount_percentage');
            $table->integer('over_month_discount_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
