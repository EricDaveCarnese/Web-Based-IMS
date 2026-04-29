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
         Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->string('category_name')->nullable();
            $table->text('damage_description');
            $table->integer('damage_quantity')->default(1);
            $table->enum('status', ['pending', 'reviewed', 'resolved'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_reports');
    }
};
