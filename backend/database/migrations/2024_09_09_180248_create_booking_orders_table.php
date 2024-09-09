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
        Schema::create('booking_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("room_id")->constrained("rooms");
            $table->foreignId("user_id")->constrained("users");
            $table->date('checkin');
            $table->date('checkout');
            $table->boolean('arrival')->default(0);
            $table->boolean('refund')->nullable();
            $table->enum('booking_status', ['pending', 'booked', 'cancelled', 'refunded'])->default('pending');
            $table->string('tran_id');
            $table->string('bank_tran_id')->nullable();
            $table->string('tran_status')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_orders');
    }
};
