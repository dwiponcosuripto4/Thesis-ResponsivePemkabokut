<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            ['user_id' => 1, 'title' => 'IKU, Renja, Renstra dan PK Perubahan Dinas Kepemudaan, Olahraga dan Pariwisata OKU Timur', 'data_id' => 2, 'date' => '2021-08-19'],
            ['user_id' => 1, 'title' => 'Pengumuman Lelang Kendaraan Dinas Kabupaten OKU Timur 2021', 'data_id' => 2, 'date' => '2021-09-01'],
            ['user_id' => 1, 'title' => 'Standar Operasional Prosedur PPID Kabupaten Ogan Komering Ulu Timur', 'data_id' => 2, 'date' => '2023-01-26'],
            ['user_id' => 1, 'title' => 'Pengumuman Penerimaan Pengadaan CPNS Pemerintah Kabupaten Ogan Komering Ulu Timur Formasi Tahun 2024', 'data_id' => 2, 'date' => '2024-08-19'],
        ];

        foreach ($documents as $document) {
            Document::create($document);
        }
    }
}
