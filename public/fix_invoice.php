<?php
/**
 * Quick fix: Add 'waiting_invoice' to orders ENUM columns.
 * Access via: https://tattooink12studio.com/fix_invoice.php?key=run-migrate-2026
 * 
 * !! DELETE THIS FILE AFTER USE FOR SECURITY !!
 */

$secretKey = 'run-migrate-2026';

if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    echo '<h1>403 Forbidden</h1>';
    exit;
}

// Boot Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<html><head><title>Fix Invoice ENUM</title>';
echo '<style>body{font-family:monospace;background:#0f0f1a;color:#22c55e;padding:2rem;} .box{background:#1a1a2e;padding:2rem;border-radius:10px;border:1px solid #333;max-width:800px;} h1{color:#d4af37;} .ok{color:#22c55e;} .warn{color:#ef4444;}</style>';
echo '</head><body><div class="box">';
echo '<h1>🔧 Fix Invoice ENUM Columns</h1>';

try {
    $pdo = DB::connection()->getPdo();

    // 1. Fix status ENUM
    $pdo->exec("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'waiting_invoice', 'paid', 'processing', 'shipped', 'completed', 'cancelled') DEFAULT 'pending'");
    echo '<p class="ok">✅ status ENUM updated — added "waiting_invoice"</p>';

    // 2. Fix payment_status ENUM
    $pdo->exec("ALTER TABLE orders MODIFY COLUMN payment_status ENUM('pending', 'waiting_invoice', 'completed', 'failed', 'refunded', 'awaiting_verification') DEFAULT 'pending'");
    echo '<p class="ok">✅ payment_status ENUM updated — added "waiting_invoice"</p>';

    echo '<br><p class="ok"><strong>🎉 All done! Invoice checkout should now work.</strong></p>';
} catch (Exception $e) {
    echo '<p class="warn">❌ Error: ' . $e->getMessage() . '</p>';
}

echo '<hr style="border-color:#333;"><p class="warn">⚠️ DELETE THIS FILE (fix_invoice.php) AFTER USE!</p>';
echo '</div></body></html>';
