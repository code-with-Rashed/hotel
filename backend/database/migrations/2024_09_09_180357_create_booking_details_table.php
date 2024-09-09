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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("booking_order_id")->constrained("booking_orders");
            $table->string('room_name');
            $table->string('price');
            $table->string('total_pay');
            $table->string('room_no')->nullable();
            $table->string('user_name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->boolean('rating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
