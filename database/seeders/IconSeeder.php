<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $icons = [
            [
                'user_id' => 1,
                'title' => 'Pelayanan Kependudukan',
                'image' => 'uploads/icons/public-service.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Pelayanan Masyarakat',
                'image' => 'uploads/icons/social-services.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Pelayanan Pajak',
                'image' => 'uploads/icons/tax.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Produk Hukum',
                'image' => 'uploads/icons/law-book.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Layanan Publik',
                'image' => 'uploads/icons/complaint.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Website OPD',
                'image' => 'uploads/icons/destination.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Inovasi Daerah',
                'image' => 'uploads/icons/calculation.png' 
            ],
            [
                'user_id' => 1,
                'title' => 'Statistik',
                'image' => 'uploads/icons/statistik.png' 
            ]
        ];

        foreach ($icons as $icon) {
            Icon::create($icon);
        }
    }
}
