<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Using content from the example layout
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'text' => 'Built based on client specification.',
                'completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'text' => 'Cross browser checks to ensure consistency of design (IE, Edge, FF, Chrome)',
                'completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'text' => 'Site is navigable with Javascript disabled',
                'completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'text' => 'Favicon updated & included in site root',
                'completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
