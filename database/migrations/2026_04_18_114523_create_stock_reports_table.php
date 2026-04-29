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
        Schema::create('stock_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user_management')->onDelete('cascade');
            $table->string('user_name');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('product_name');
            $table->integer('current_stock');
            $table->integer('min_stock_level');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'read', 'ordered', 'notified'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->boolean('user_notified')->default(false);
            $table->timestamp('user_notified_at')->nullable();
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate pending reports for same product
            $table->unique(['product_id', 'status'], 'unique_pending_report');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_reports');
    }
};
