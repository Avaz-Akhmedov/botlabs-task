<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manager::query()->firstOrCreate([
            'name' => 'Test manager'
        ]);

        Manager::query()->firstOrCreate([
            'name' => 'Second Test manager'
        ]);
    }
}
