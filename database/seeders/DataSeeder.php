<?php

namespace Database\Seeders;

use App\Models\Data;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $data = [
            ['title' => 'Rencana Umum Pengadaan', 'category_id' => 6],
            ['title' => 'Umum', 'category_id' => 6],
            ['title' => 'Data Umum', 'category_id' => 7],
            ['title' => 'Perancangan Daerah', 'category_id' => 7],
            ['title' => 'Keuangan Daerah', 'category_id' => 7],
            ['title' => 'Lakip', 'category_id' => 7],
            ['title' => 'Dana Desa', 'category_id' => 7],
            ['title' => 'PERDA OKU TIMUR', 'category_id' => 7],
            ['title' => 'PERBUB OKU TIMUR', 'category_id' => 7],
            ['title' => 'PPIP', 'category_id' => 7],
            ['title' => 'Data Sektoral', 'category_id' => 7],
        ];

        foreach ($data as $item) {
            Data::create($item);
        }        
    }
}
