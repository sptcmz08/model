<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $now = now();

        // Insert Pre-order and Instock categories if they don't already exist
        $categories = [
            ['name' => 'Pre-order', 'slug' => 'pre-order', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Instock', 'slug' => 'instock', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }

    public function down(): void
    {
        DB::table('categories')->whereIn('slug', ['pre-order', 'instock'])->delete();
    }
};
