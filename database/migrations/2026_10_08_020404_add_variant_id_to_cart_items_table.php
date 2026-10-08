<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan variant_id terlebih dahulu
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('variant_id')
                ->nullable()
                ->after('product_id')
                ->constrained('product_variants')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        // 2. Buat index pendukung untuk foreign key product_id
        //    sebelum unique index lama dihapus.
        Schema::table('cart_items', function (Blueprint $table) {
            $table->index(
                ['cart_id', 'product_id'],
                'cart_items_cart_id_product_id_index'
            );
        });

        // 3. Hapus unique lama dan buat unique baru
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(
                'cart_items_cart_id_product_id_unique'
            );

            $table->unique(
                ['cart_id', 'product_id', 'variant_id'],
                'cart_items_cart_product_variant_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropUnique(
                'cart_items_cart_product_variant_unique'
            );

            $table->unique(
                ['cart_id', 'product_id'],
                'cart_items_cart_id_product_id_unique'
            );

            $table->dropIndex(
                'cart_items_cart_id_product_id_index'
            );

            $table->dropForeign(['variant_id']);

            $table->dropColumn('variant_id');
        });
    }
};