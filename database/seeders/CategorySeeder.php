<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Profil', 'Geografis', 'Pemerintahan', 'Potensi', 'Infrastruktur',
            'Pengumuman', 'Data', 'Serba-serbi', 'Kebijakan Privasi'
        ];

        foreach ($categories as $category) {
            Category::create(['title' => $category]);
        }
    }
}
