<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buslists', function (Blueprint $table) {
            $table->id();
            $table->string('bus_name');
            $table->string('departing_time');
            $table->string('coach_no');
            $table->string('starting_point');
            $table->string('ending_point');
            $table->decimal('fare', 8, 2);
            $table->string('coach_type');
            $table->unsignedInteger('seats_available')->default(40);
            $table->string('view')->default('0000000000000000000000000000000000000000');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buslists');
    }
};
