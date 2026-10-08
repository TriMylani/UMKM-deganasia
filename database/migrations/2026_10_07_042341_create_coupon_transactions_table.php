<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupon_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('type', [
                'earned',
                'redeemed',
                'adjustment',
            ]);

            $table->unsignedInteger('quantity');

            $table->text('description')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_transactions');
    }
};