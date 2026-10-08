<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedTinyInteger('rating');

            $table->text('comment')->nullable();

            $table->boolean('is_visible')->default(true);

            $table->timestamps();

            $table->unique([
                'user_id',
                'product_id',
                'order_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};