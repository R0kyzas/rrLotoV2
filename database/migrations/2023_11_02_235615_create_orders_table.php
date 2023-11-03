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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('active')->default(0);
            $table->boolean('payment_method');
            $table->integer('ticket_quantity');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('order_nr')->unique();
            $table->string('cancel_reason', 255)->nullable(true);
            $table->integer('final_price');
            $table->uuid('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
