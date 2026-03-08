<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('continent')->unique();
            $table->string('label');
            $table->decimal('rate', 8, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed default continents
        DB::table('shipping_rates')->insert([
            ['continent' => 'asia', 'label' => 'Asia', 'rate' => 15.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['continent' => 'europe', 'label' => 'Europe', 'rate' => 20.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['continent' => 'americas', 'label' => 'Americas', 'rate' => 25.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['continent' => 'oceania', 'label' => 'Oceania', 'rate' => 20.00, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
