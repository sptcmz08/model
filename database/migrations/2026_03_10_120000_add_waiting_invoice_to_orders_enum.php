<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add 'waiting_invoice' to the status ENUM
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'waiting_invoice', 'paid', 'processing', 'shipped', 'completed', 'cancelled') DEFAULT 'pending'");

        // Add 'waiting_invoice' to the payment_status ENUM
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'waiting_invoice', 'completed', 'failed', 'refunded', 'awaiting_verification') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled') DEFAULT 'pending'");
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'completed', 'failed', 'refunded', 'awaiting_verification') DEFAULT 'pending'");
    }
};
