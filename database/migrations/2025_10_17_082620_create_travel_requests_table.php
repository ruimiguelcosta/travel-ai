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
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->string('destination_country');
            $table->string('destination_city');
            $table->json('preferences');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('status')->default('pending');
            $table->json('search_results')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_requests');
    }
};
