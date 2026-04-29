<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stock_reports', function (Blueprint $table) {
            DB::statement("ALTER TABLE stock_reports MODIFY COLUMN status ENUM('pending', 'read', 'ordered', 'resolved') DEFAULT 'pending'");
        });
    }

    public function down()
    {
        DB::statement("ALTER TABLE stock_reports MODIFY COLUMN status ENUM('pending', 'read', 'ordered') DEFAULT 'pending'");
    }
};