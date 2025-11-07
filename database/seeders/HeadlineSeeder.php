<?php

namespace Database\Seeders;

use App\Models\Headline;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HeadlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headlines = [
            ['title' => 'Headlines OKU Timur'],
            ['title' => 'Artikel', 'category_id' => 8],
            ['title' => 'Berita Daerah', 'category_id' => 8],
            ['title' => 'Berita Umum', 'category_id' => 8],
            ['title' => 'Serba serbi', 'category_id' => 8]
        ];

        foreach ($headlines as $headline) {
            Headline::create($headline);
        }
    }
}
