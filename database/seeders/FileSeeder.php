<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = [
            [
                'title' => 'IKU DISPORAPAR',
                'file_path' => 'http://www.okutimurkab.go.id/wp-content/uploads/2021/08/IKU-DISPORAPAR.pdf',
                'file_date' => '2021-08-19',
                'document_id' => 1,
            ],
            [
                'title' => 'RENJA DISPORAPAR 2020',
                'file_path' => 'http://www.okutimurkab.go.id/wp-content/uploads/2021/08/RENJA-DISPORAPAR-2020.pdf',
                'file_date' => '2021-08-19',
                'document_id' => 1,
            ],
            [
                'title' => 'RENSTRA 2016-2021 DISPORAPAR',
                'file_path' => 'http://www.okutimurkab.go.id/wp-content/uploads/2021/08/RENSTRA-2016-2021-DISPORAPAR.pdf',
                'file_date' => '2021-08-19',
                'document_id' => 1,
            ],
            [
                'title' => 'PK PERUBAHAN TAHUN 2020',
                'file_path' => 'http://www.okutimurkab.go.id/wp-content/uploads/2021/08/PK-PERUBAHAN-TAHUN-2020.pdf',
                'file_date' => '2021-08-19',
                'document_id' => 1,
            ],
            [
                'title' => 'PENGUMUMAN LELANG KENDARAAN DINAS KABUPATEN OKU TIMUR 2021',
                'file_path' => 'http://www.okutimurkab.go.id/wp-content/uploads/2021/09/PENGUMUMAN-LELANG-KENDARAAN-DINAS-KABUPATEN-OKU-TIMUR-2021.pdf',
                'file_date' => '2021-01-01',
                'document_id' => 2,
            ],
            [
                'title' => 'SOP PPID',
                'file_path' => 'https://www.okutimurkab.go.id/wp-content/uploads/2023/01/SOP-PPID.pdf',
                'file_date' => '2023-01-26',
                'document_id' => 3,
            ],
            [
                'title' => 'Pengumuman Formasi CPNS 2024',
                'file_path' => 'https://okutimurkab.go.id/wp-content/uploads/2024/08/pengumuman_formasi_cpns2024_OKUT.pdf.pdf',
                'file_date' => '2024-08-19',
                'document_id' => 4,
            ],
        ];

        foreach ($files as $file) {
            File::create($file);
        }
    }
}
