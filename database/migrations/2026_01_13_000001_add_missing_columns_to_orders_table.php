<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add billing_address if not exists
            if (!Schema::hasColumn('orders', 'billing_address')) {
                $table->text('billing_address')->nullable()->after('shipping_address');
            }
            
            // Add tracking_number if not exists
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('payment_status');
            }
        });

        // Update payment_status enum to include 'awaiting_verification'
        // Note: MySQL doesn't support ALTER for ENUM easily, so we'll handle this differently
        // by modifying the column type
        try {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'completed', 'failed', 'refunded', 'awaiting_verification') DEFAULT 'pending'");
        } catch (\Exception $e) {
            // If it fails (e.g., SQLite), just ignore
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'billing_address')) {
                $table->dropColumn('billing_address');
            }
            if (Schema::hasColumn('orders', 'tracking_number')) {
                $table->dropColumn('tracking_number');
            }
        });
    }
};
