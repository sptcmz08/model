<?php

// Define paths relative to this public folder
// Assuming structure: /project/public/fix.php and /project/storage/
$storagePath = realpath(__DIR__ . '/../storage');
$publicPath = __DIR__;

echo "<h1>Laravel Fixer Tool</h1>";
echo "Storage Path: " . ($storagePath ?: 'NOT FOUND') . "<br>";
echo "Public Path: " . $publicPath . "<br><hr>";

if (!$storagePath) {
    die("❌ Error: Could not find storage directory. Check file structure.");
}

// 1. Create Necessary Directories
$dirs = [
    $storagePath . '/framework',
    $storagePath . '/framework/views',
    $storagePath . '/framework/cache',
    $storagePath . '/framework/sessions',
    $storagePath . '/app/public',
];

foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "✅ Created directory: $dir<br>";
        } else {
            echo "❌ Failed to create directory: $dir (Check folder permissions)<br>";
        }
    } else {
        echo "✅ Directory exists: $dir<br>";
    }
}

echo "<hr>";

// 2. Fix Storage Symlink
$target = $storagePath . '/app/public';
$link = $publicPath . '/storage';

echo "Target for link: $target<br>";
echo "Link location: $link<br>";

if (file_exists($link)) {
    // Check if it's a real directory (problematic) or a symlink
    if (is_dir($link) && !is_link($link)) {
        $backupName = $publicPath . '/storage_backup_' . time();
        if (rename($link, $backupName)) {
            echo "⚠️ Renamed existing real directory 'storage' to '" . basename($backupName) . "'<br>";
        } else {
            echo "❌ Failed to rename existing 'storage' directory. Please delete it manually via FTP/File Manager.<br>";
        }
    } else {
        // It is a link or file, delete it
        if (@unlink($link)) {
            echo "⚠️ Removed existing link/file.<br>";
        } else {
            echo "❌ Failed to remove existing link. Please delete it manually.<br>";
        }
    }
}

// Create new symlink
if (symlink($target, $link)) {
    echo "✅ <b>SUCCESS: Symlink created successfully!</b><br>";
} else {
    echo "❌ <b>FAILED: Could not create symlink.</b><br>";
    echo "Reason: The 'symlink' function might be disabled on this server, or permissions are denied.<br>";
}

echo "<hr>";
echo "<h3>Instructions:</h3>";
echo "1. Verify if your images are showing now.<br>";
echo "2. <b>IMPORTANT: Delete this fix.php file from your server effectively immediately after use for security.</b>";
