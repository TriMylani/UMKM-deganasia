<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('admin_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('coupon_quantity');
            $table->unsignedInteger('reward_quantity')->default(1);

            $table->string('reward_name')
                ->default('Kelapa Puding');

            $table->text('note')->nullable();

            $table->timestamp('redeemed_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};