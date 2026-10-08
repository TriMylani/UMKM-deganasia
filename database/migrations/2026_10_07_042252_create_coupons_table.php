<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->enum('type', [
                'percentage',
                'fixed',
                'loyalty',
            ]);

            $table->decimal('value', 12, 2)->default(0);

            $table->unsignedInteger('max_usage')->nullable();
            $table->unsignedInteger('usage_count')->default(0);

            $table->decimal('minimum_order', 12, 2)->default(0);

            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};