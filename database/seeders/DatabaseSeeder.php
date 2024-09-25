<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Invoice::factory()->withLines(rand(1,10))->count(100)->create();
    }
}
