<?php
/**
 * Web-based migration runner for shared hosting without SSH access.
 * Access via: https://tattooink12studio.com/migrate.php
 * 
 * !! DELETE THIS FILE AFTER USE FOR SECURITY !!
 */

// Simple security key — change this if needed
$secretKey = 'run-migrate-2026';

if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    echo '<h1>403 Forbidden</h1>';
    echo '<p>Access denied. Use: ?key=' . $secretKey . '</p>';
    exit;
}

// Boot Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<html><head><title>Migration Runner</title>';
echo '<style>body{font-family:monospace;background:#0f0f1a;color:#22c55e;padding:2rem;} .box{background:#1a1a2e;padding:2rem;border-radius:10px;border:1px solid #333;max-width:800px;} h1{color:#d4af37;} .warn{color:#ef4444;font-weight:bold;} a{color:#3b82f6;}</style>';
echo '</head><body><div class="box">';

$action = $_GET['action'] ?? 'status';

echo '<h1>🔧 Migration Runner</h1>';
echo '<p><a href="?key=' . $secretKey . '&action=status">Status</a> | ';
echo '<a href="?key=' . $secretKey . '&action=migrate">Run Migrate</a> | ';
echo '<a href="?key=' . $secretKey . '&action=seed">Run Seed</a> | ';
echo '<a href="?key=' . $secretKey . '&action=migrate-seed">Migrate + Seed</a> | ';
echo '<a href="?key=' . $secretKey . '&action=clear-cache">Clear Cache</a></p>';
echo '<hr style="border-color:#333;">';

try {
    switch ($action) {
        case 'migrate':
            echo '<h2>Running: php artisan migrate</h2>';
            Artisan::call('migrate', ['--force' => true]);
            echo '<pre>' . Artisan::output() . '</pre>';
            break;

        case 'seed':
            echo '<h2>Running: php artisan db:seed</h2>';
            Artisan::call('db:seed', ['--force' => true]);
            echo '<pre>' . Artisan::output() . '</pre>';
            break;

        case 'migrate-seed':
            echo '<h2>Running: php artisan migrate + seed</h2>';
            Artisan::call('migrate', ['--force' => true]);
            echo '<pre>' . Artisan::output() . '</pre>';
            Artisan::call('db:seed', ['--force' => true]);
            echo '<pre>' . Artisan::output() . '</pre>';
            break;

        case 'clear-cache':
            echo '<h2>Clearing all caches</h2>';
            Artisan::call('cache:clear');
            echo '<pre>' . Artisan::output() . '</pre>';
            Artisan::call('config:clear');
            echo '<pre>' . Artisan::output() . '</pre>';
            Artisan::call('view:clear');
            echo '<pre>' . Artisan::output() . '</pre>';
            Artisan::call('route:clear');
            echo '<pre>' . Artisan::output() . '</pre>';
            break;

        default:
            echo '<h2>Migration Status</h2>';
            Artisan::call('migrate:status');
            echo '<pre>' . Artisan::output() . '</pre>';
            break;
    }

    echo '<p style="color:#22c55e;">✅ Done!</p>';
} catch (Exception $e) {
    echo '<p class="warn">❌ Error: ' . $e->getMessage() . '</p>';
}

echo '<hr style="border-color:#333;"><p class="warn">⚠️ DELETE THIS FILE (migrate.php) AFTER USE!</p>';
echo '</div></body></html>';
