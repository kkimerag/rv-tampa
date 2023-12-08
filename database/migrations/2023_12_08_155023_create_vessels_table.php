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
        Schema::create('vessels', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('make');
            $table->string('model');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('rate_id');
            $table->integer('sleeps');
            $table->integer('beds');
            $table->integer('length');
            $table->integer('weight');
            $table->integer('hitch_weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessels');
    }
};
