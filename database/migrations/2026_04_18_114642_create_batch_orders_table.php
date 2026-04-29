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
        Schema::create('batch_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('supplier_name');
            $table->date('order_date');
            $table->date('deadline');
            $table->enum('status', ['pending', 'partial', 'completed', 'canceled'])->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('batch_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_order_id')->constrained('batch_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('quantity_ordered');
            $table->integer('quantity_received')->default(0);
            $table->decimal('price_at_order', 10, 2);
            $table->decimal('price_at_delivery', 10, 2)->nullable();
            $table->enum('status', ['pending', 'received', 'partial', 'price_adjusted'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_order_items');
        Schema::dropIfExists('batch_orders');
    }
};
