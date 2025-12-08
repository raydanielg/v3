<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create regions table
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('population')->nullable();
            $table->string('capital')->nullable();
            $table->timestamps();
        });

        // Create districts table
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->integer('population')->nullable();
            $table->string('headquarters')->nullable();
            $table->timestamps();
        });

        // Insert sample regions
        \DB::table('regions')->insert([
            [
                'name' => 'Dar es Salaam',
                'code' => 'DSM',
                'description' => 'Largest city and economic hub',
                'population' => 6000000,
                'capital' => 'Dar es Salaam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arusha',
                'code' => 'ARU',
                'description' => 'Northern region',
                'population' => 1700000,
                'capital' => 'Arusha',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kilimanjaro',
                'code' => 'KLM',
                'description' => 'Northern highlands',
                'population' => 1600000,
                'capital' => 'Moshi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dodoma',
                'code' => 'DDM',
                'description' => 'Capital region',
                'population' => 2100000,
                'capital' => 'Dodoma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Morogoro',
                'code' => 'MRG',
                'description' => 'Eastern region',
                'population' => 2200000,
                'capital' => 'Morogoro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert sample districts
        \DB::table('districts')->insert([
            // Dar es Salaam districts
            ['region_id' => 1, 'name' => 'Ilala', 'code' => 'DSM-ILA', 'headquarters' => 'Ilala', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 1, 'name' => 'Kinondoni', 'code' => 'DSM-KIN', 'headquarters' => 'Kinondoni', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 1, 'name' => 'Temeke', 'code' => 'DSM-TEM', 'headquarters' => 'Temeke', 'created_at' => now(), 'updated_at' => now()],
            
            // Arusha districts
            ['region_id' => 2, 'name' => 'Arusha City', 'code' => 'ARU-CTY', 'headquarters' => 'Arusha', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 2, 'name' => 'Arusha District', 'code' => 'ARU-DST', 'headquarters' => 'Arusha', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 2, 'name' => 'Monduli', 'code' => 'ARU-MON', 'headquarters' => 'Monduli', 'created_at' => now(), 'updated_at' => now()],
            
            // Kilimanjaro districts
            ['region_id' => 3, 'name' => 'Moshi', 'code' => 'KLM-MSH', 'headquarters' => 'Moshi', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 3, 'name' => 'Rombo', 'code' => 'KLM-ROM', 'headquarters' => 'Rombo', 'created_at' => now(), 'updated_at' => now()],
            
            // Dodoma districts
            ['region_id' => 4, 'name' => 'Dodoma City', 'code' => 'DDM-CTY', 'headquarters' => 'Dodoma', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 4, 'name' => 'Dodoma District', 'code' => 'DDM-DST', 'headquarters' => 'Dodoma', 'created_at' => now(), 'updated_at' => now()],
            
            // Morogoro districts
            ['region_id' => 5, 'name' => 'Morogoro City', 'code' => 'MRG-CTY', 'headquarters' => 'Morogoro', 'created_at' => now(), 'updated_at' => now()],
            ['region_id' => 5, 'name' => 'Morogoro District', 'code' => 'MRG-DST', 'headquarters' => 'Morogoro', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
        Schema::dropIfExists('regions');
    }
};
