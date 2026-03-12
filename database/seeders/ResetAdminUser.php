<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ResetAdminUser extends Seeder
{
    public function run(): void
    {
        // 1. Ensure username column exists
        if (!Schema::hasColumn('admins', 'username')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('username')->unique()->nullable()->after('email');
            });
            $this->command->info('Added username column to admins table.');
        }

        // 2. Clear existing admins to avoid duplicates/conflicts
        Admin::truncate();

        // 3. Create fresh Admin user
        Admin::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@tattooink12studio.com',
            'password' => Hash::make('password'),
        ]);

        $this->command->info('Admin user reset successfully.');
        $this->command->info('Username: admin');
        $this->command->info('Password: password');
    }
}
