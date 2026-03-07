<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for Shared Hosting: Ensure storage directories exist
        if (!is_dir(storage_path('framework/views'))) {
            mkdir(storage_path('framework/views'), 0755, true);
        }
        if (!is_dir(storage_path('framework/cache/data'))) {
            mkdir(storage_path('framework/cache/data'), 0755, true);
        }
        if (!is_dir(storage_path('framework/sessions'))) {
            mkdir(storage_path('framework/sessions'), 0755, true);
        }

        // Fix for Shared Hosting: Ensure public/storage symlink exists
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');

        if (!windows_os() && !file_exists($linkPath)) {
            if (file_exists($targetPath)) {
                @symlink($targetPath, $linkPath);
            }
        }
    }
}
