<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Rata-Rata Nilai Pengetahuan', 'type' => 'benefit', 'p_threshold' => '0.1', 'priority_value' => '5'],
            ['name' => 'Rata-Rata Nilai Keterampilan', 'type' => 'benefit', 'p_threshold' => '0.1', 'priority_value' => '5'],
            ['name' => 'Jumlah Sakit', 'type' => 'cost', 'p_threshold' => '3', 'priority_value' => '3'],
            ['name' => 'Jumlah Izin', 'type' => 'cost', 'p_threshold' => '2', 'priority_value' => '3'],
            ['name' => 'Jumlah Tanpa Keterangan', 'type' => 'cost', 'p_threshold' => '1', 'priority_value' => '3'],
            ['name' => 'Prestasi Non-Akademik', 'type' => 'benefit', 'p_threshold' => '2', 'priority_value' => '2'],
            ['name' => 'Keaktifan Organisasi', 'type' => 'benefit', 'p_threshold' => '1', 'priority_value' => '2'],
        ];

        foreach ($data as $item) {
            Criteria::create([
                'name' => $item['name'],
                'type' => $item['type'],
                'p_threshold' => $item['p_threshold'],
                'priority_value' => $item['priority_value'],
            ]);
        }
    }
}
