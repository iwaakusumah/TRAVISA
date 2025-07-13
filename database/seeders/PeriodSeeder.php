<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => '2023/2024'],
            ['name' => '2024/2025'],
            ['name' => '2025/2026'],
        ];

        foreach ($data as $item) {
            Period::create([
                'name' => $item['name'],
            ]);
    }
}
}