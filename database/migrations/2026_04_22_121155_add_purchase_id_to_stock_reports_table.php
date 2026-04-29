<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column exists using try-catch
        try {
            Schema::table('stock_reports', function (Blueprint $table) {
                // Check if column exists by trying to add it
                if (!Schema::hasColumn('stock_reports', 'purchase_id')) {
                    $table->unsignedBigInteger('purchase_id')->nullable()->after('status');
                    $table->foreign('purchase_id')
                          ->references('id')
                          ->on('purchases')
                          ->nullOnDelete();
                }
            });
        } catch (\Exception $e) {
            // If column already exists or foreign key issue, try to add just the column
            if (!Schema::hasColumn('stock_reports', 'purchase_id')) {
                Schema::table('stock_reports', function (Blueprint $table) {
                    $table->unsignedBigInteger('purchase_id')->nullable()->after('status');
                });
            }
        }
    }

    public function down(): void
    {
        Schema::table('stock_reports', function (Blueprint $table) {
            // Check if foreign key exists before dropping
            if (Schema::hasColumn('stock_reports', 'purchase_id')) {
                try {
                    $table->dropForeign(['purchase_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
                $table->dropColumn('purchase_id');
            }
        });
    }
};