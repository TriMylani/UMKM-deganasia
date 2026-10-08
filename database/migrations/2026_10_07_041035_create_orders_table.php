<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_number')->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('address_id')
                ->nullable()
                ->constrained('addresses')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->date('order_date');

            $table->enum('pickup_method', [
                'pickup_cfd',
                'pickup_rumah',
                'delivery',
                'cod',
            ]);

            $table->text('delivery_address')->nullable();

            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);

            $table->enum('status', [
                'diterima',
                'diproses',
                'dikemas',
                'dikirim',
                'dalam_perjalanan',
                'selesai',
                'ditolak',
                'dibatalkan',
            ])->default('diterima');

            $table->text('admin_note')->nullable();
            $table->text('customer_note')->nullable();

            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};