<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            ['title' => 'Sejarah', 'user_id' => 1, 'category_id' => 1, 'description' => 'Ini adalah deskripsi untuk Sejarah.'],
            ['title' => 'Arti Lambang', 'user_id' => 1, 'category_id' => 1],
            ['title' => 'Motto Daerah', 'user_id' => 1, 'category_id' => 1],
            ['title' => 'Visi dan Misi', 'user_id' => 1, 'category_id' => 1],
            ['title' => 'Pendidikan', 'user_id' => 1, 'category_id' => 1],
            ['title' => 'Kesehatan', 'user_id' => 1, 'category_id' => 1],
            ['title' => 'Agama', 'user_id' => 1, 'category_id' => 1],
            ['title' => 'Tenaga Kerja', 'user_id' => 1, 'category_id' => 1],

            ['title' => 'Peta Wilayah', 'user_id' => 1, 'category_id' => 2],
            ['title' => 'Letak, Luas & Batas', 'user_id' => 1, 'category_id' => 2],
            ['title' => 'Cuaca & Iklim', 'user_id' => 1, 'category_id' => 2],
            ['title' => 'Topografi', 'user_id' => 1, 'category_id' => 2],
            ['title' => 'Demografi', 'user_id' => 1, 'category_id' => 2],
            ['title' => 'Sosial - Ekonomi', 'user_id' => 1, 'category_id' => 2],
            ['title' => 'Budaya Daerah', 'user_id' => 1, 'category_id' => 2],

            ['title' => 'Bupati OKU Timur', 'user_id' => 1, 'category_id' => 3],
            ['title' => 'Wakil Bupati OKU Timur', 'user_id' => 1, 'category_id' => 3],
            ['title' => 'Sekretaris Daerah', 'user_id' => 1, 'category_id' => 3],
            ['title' => 'Asisten I', 'user_id' => 1, 'category_id' => 3],
            ['title' => 'Asisten II', 'user_id' => 1, 'category_id' => 3],
            ['title' => 'Asisten III', 'user_id' => 1, 'category_id' => 3],
            ['title' => 'Kepala Dinas', 'user_id' => 1, 'category_id' => 3],

            ['title' => 'Perkebunan', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Pertanian', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Peternakan dan Perikanan', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Kehutanan', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Pertambangan', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Perindustrian', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Perdagangan', 'user_id' => 1, 'category_id' => 4],
            ['title' => 'Pariwisata', 'user_id' => 1, 'category_id' => 4],

            ['title' => 'Jalan dan Kereta Api', 'user_id' => 1, 'category_id' => 5],
            ['title' => 'Listrik', 'user_id' => 1, 'category_id' => 5],
            ['title' => 'Telekomunikasi', 'user_id' => 1, 'category_id' => 5],
            ['title' => 'Sarana Air Bersih', 'user_id' => 1, 'category_id' => 5],

            ['title' => 'Galeri', 'user_id' => 1, 'category_id' => 8],

            ['title' => 'Kebijakan Privasi', 'user_id' => 1, 'category_id' => 9],

            [
                'title' => 'Buka Lomba Senam Lansia dan Jantung Sehat, dr. Sheila Bangga Dengan Jelita dan Lolita',
                'user_id' => 1,
                'category_id' => null,
                'headline_id' => 1,
                'image' => json_encode([
                    'uploads/seeder/pertama (1).jpeg','uploads/seeder/pertama (2).jpeg','uploads/seeder/pertama (3).jpeg','uploads/seeder/pertama (4).jpeg','uploads/seeder/pertama (5).jpeg','uploads/seeder/pertama (6).jpeg','uploads/seeder/pertama (7).jpeg','uploads/seeder/pertama (8).jpeg'
                ]),
                'description' => '<p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">OKU Timur – Pemerintah Kabupaten OKU Timur melalui Dinas Kesehatan bekerjasama dengan Yayasan Jantung Indonesia dan TP PKK Kabupaten OKU Timur mengadakan Lomba Senam Lansia dan Senam Jantung Sehat di Balai Rakyat, Jum’at, 20 September 2024.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Acara tersebut dibuka langsung oleh Ketua TP PKK OKU Timur sekaligus Ketua YJI Cabang OKU Timur dr. Sheila Noberta, Sp.A. M.Kes didampingi Wakil Ketua TP PKK sekaligus Ketua Perwosi OKU Timur Nur Inayah, S.Pd dan Sekretaris Dinas Kesehatan Elwana, SKM.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Dalam laporannya, Kepala Dinas Kesehatan melalui Ketua Panitia Pelaksana Elwana, SKM menyampaikan bahwa Kegiatan ini ada 2 jenis lomba yaitu Senam Lansia dan Senam Jantung Sehat yang diikuti oleh peserta dari 20 kecamatan.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Selanjutnya tujuan daripada pelaksanaan kegiatan ini secara umum adalah untuk untuk meningkatkan kesehatan jasmani dan kesadaran masyarakat tentang pentingnya berolahraga sehingga dapat menekan angka kesakitan dan meningkatkan umur usia harapan hidup. Peserta lomba berjumlah 200 orang peserta yang diutus dari 20 Kecanatan”, jelasnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Adapun Dewan Juri Pada Lomba Senam Lansia dan Senam Jantung Sehat Tahun 2024 ini antara lain dari Yayasan Jantung Indonesia, Dinas Kesehatan, Dinas Pemuda Olahraga dan Pariwisata serta dari Tim Penggerak PKK Kabupaten OKU Timur.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Dalam bimbingan dan arahannya, Ketua TP PKK sekaligus Ketua YJI Cabang OKU Timur dr. Sheila Noberta, Sp.A. M.Kes menyampaikan rasa bangga dirinya dapat berjumpa dengan peserta lomba senam baik dari Lansia maupun peserta Senam Jantung Sehat.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Saya senang hari ini bisa bertemu dengan para Jelita atau Jelang Lima Puluh Tahun dan juga Lolita atau Lolos Lima Puluh Tahun yang terus semangat untuk melaksanakan olahraga senam. Namun kita ketahui bahwa banyak olahraga lain yang dapat kita jalani di usia saat ini seperti olahraga kardio, berenang dan bersepeda”, ungkapnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">dr. Sheila juga menjelaskan bahwa Senam Jantung merupakan senam yang sangat populer dan cocok untuk semua orang serta menjadi senam yang disusun dengan selalu mengutamakan kemampuan jantung, gerakan otot besar dan kelenturan sendi agar dapat memasukan sebanyak mungkin oksigen ke dalam tubuh.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Kemudian Senam Lansia juga dapat menciptakan suasana gembira sebab di usia tua, akutivitas lansia sudah berkurang sehingga butuh kegiatan agar tubuh tidak kaku, selain itu Lansia merasa diperhatikan dan dihargai di tengah masuarakat sehingga semangat menjalani hari tua”, ujarnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Di akhir pidatonya, dr. Sheila mengajak semua masyarakat termasuk lansia untuk terus menerapkan pola hidup sehat dan menjaga asupan yang menjadi konsumsi sehari-hari dengan memperhatikan kandungan gizi yang ada di dalamnya. Ia juga mendukung semua Lansia untuk terus berkegiatan seperti senam agar dapat meminimalisir resiko penyakit terutama di usia yang tak muda lagi.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Tim Diskominfo</p>',
                'published_at' => '2024-09-26',
            ],
            [
                'title' => 'Masyarakat Membludak, Bang Enos Hadiri Pesta Rakyat Bersama Endank Soekamti.',
                'user_id' => 1,
                'category_id' => null,
                'headline_id' => 1,
                'image' => json_encode([
                    'uploads/seeder/kedua (1).jpeg',
                    'uploads/seeder/kedua (2).jpeg',
                    'uploads/seeder/kedua (3).jpeg',
                    'uploads/seeder/kedua (4).jpeg'
                ]),
                'description' => '<p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">OKU Timur – Bupati OKU Timur Ir. H. Lanosin. M.T. Hadiri Pesta Rakyat Bersama Endank Soekamti, Di Lapangan KONI Belitang, (20 September 2024).</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Acara tersebut berlangsung dengan meriah, ribuan masyarakat padati tempat konser Pesta Rakyat bersama Endank Soekamti sebagai bintang tamunya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Bupati Enos dalam konser tersebut juga ikut menyanyi dan larut dalam suasana riang bergembira menyatu dengan masyarakat serta memberikan motivasi kepada para kaum pemuda agar selalu semangat dan memberikan kontribusi yang terbaik untuk kabupaten yang kita cintai ini. Ucapnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Lanjutnya Bupati dalam sambutan singkatnya mengatakan “bahwa Pesta rakyat ini Saya persembahkan untuk masyarakat OKU Timur yang sangat saya cintai, dan kita semua harus riang gembira pada sore hari ini. Tutupnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Masyarakat bertepuk tangan dan bersorak gembira setelah usai mendengarkan sambutan Bupati, selajutnya masyarakat bernyanyi dan berheforia bersama band kesayangannya dengan tak henti-hentinya meminta panitia untuk disemprot air dari 3 mobil pemadam kebakaran yang dikerahkan dalam acara konser tersebut, agar suasananya menjadi dingin dan tidak panas.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Tim Diskominfo</p>',
                'published_at' => '2024-09-26',
            ],
            
            [
                'title' => 'Pemerintah Kabupaten OKU Timur melalui Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DPPPA) berkolaborasi dengan Tim Penggerak PKK menggelar Lomba dan Pembinaan Pola Asuh Anak dan Remaja (PAAR) di Era Digital.',
                'user_id' => 1,
                'category_id' => null,
                'headline_id' => 1,
                'image' => json_encode([
                    'uploads/seeder/ketiga (1).jpeg','uploads/seeder/ketiga (1).jpg','uploads/seeder/ketiga (2).jpeg','uploads/seeder/ketiga (2).jpg'
                ]),
                'description' => '<p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">OKU Timur – Dibuka langsung oleh Ketua TP. PKK Kabupaten OKU Timur dr. Sheila Noberta, Sp.A., M.Kes. didampingi Wakil Ketua TP. PKK Nur Inayah, S.Pd., peserta pembinaan merupakan seluruh ketua dan pengurus TP. PKK Kecamatan se-Kabupaten OKU Timur dan perlombaan diikuti oleh Kader Pokja 1 TP. PKK Kecamatan. Jum’at, 20 September 2024 di Graha Tani Hotel Parai Martapura.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Dalam sambutan dan arahannya, dr. Sheila menekankan pentingnya memiliki kemampuan bagi Pokja 1 untuk memberikan penyuluhan-penyuluhan sesuai dengan program pokok PKK yang dijalankan di desa tersebut.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Tugas Pokja 1 adalah membentuk karakter keluarga, jika dilihat dari program kerjanya, maka Pokja 1 merupakan garda terdepan terjadinya perubahan perilaku terhadap masyarakat,” tuturnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">dr. Sheila juga mengingatkan seluruh kader PKK untuk terus belajar, terlebih di era digital.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Kita harus manfaatkan teknologi, ada banyak sekali leaflet di internet sebagai media belajar, namun tetap harus diseleksi,” tambahnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Dirinya berharap, dengan adanya kegiatan ini kemampuan kader PKK dapat lebih ditingkatkan, ilmu yang didapat bisa diterapkan di tempat masing-masing sehingga tujuan dari Pokja 1 sebagai garda terdepan perubahan perilaku dapat tercapai,” ucapnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Plt. Kepala Dinas DPPPA Inoferwanti Intan, S.E., dalam laporannya mengatakan tujuaj dari kegiatan ini adalah untuk mewujudkan pemenuhan hak dan perlindungan anak di Kabupaten OKU Timur.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Melalui pembinaan dan lomba PAAR diharapkan semua kader dan anggota TP. PKK se-Kabupaten OKU Timur dapat mengerti besarnya bahaya perkawinan anak,” tutupnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Tim Diskominfo</p>',
                'published_at' => '2024-09-26',
            ],
            [
                'title' => 'Bupati OKU Timur Hadiri Pelantikan Kepengurusan Ikatan Jurnalis Televisi Indonesia (IJTI) Kabupaten OKU Timur.',
                'user_id' => 1,
                'category_id' => null,
                'headline_id' => 1,
                'image' => json_encode([
                    'uploads/seeder/keempat (1).jpg','uploads/seeder/keempat (1).png','uploads/seeder/keempat (2).jpg','uploads/seeder/keempat (3).jpg','uploads/seeder/keempat (4).jpg','uploads/seeder/keempat (5).jpg'
                ]),
                'description' => '<p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">OKU Timur – Kepengurusan Ikatan Jurnalis Televisi Indonesia (IJTI) Kabupaten OKU Timur telah resmi dilantik langsung Oleh Sekjen IJTI Provinsi Sumatera Selatan pada tanggal 20 September 2024. Disaksikan Langsung Oleh Bupati OKU Timur Ir. H. Lanosin M.T., pemberian surat mandat oleh Sekjen IJTI Provinsi Sumatera Selatan kepada kepengurusan IJTI Kabupaten OKU Timur yaitu Elvandri Jefriadi sebagai Ketua, Jadmiko Sebagai Sekertaris serta Patra sebagai Bendahara.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Bupati OKU Timur dalam sambutan dan arahannya menyampaikan harapannya kepada seluruh anggota IJTI Kabupaten OKU Timur yang telah dilantik agar selalu berpegang teguh pada visi misi dari Ikatan Jurnalis Televisi Indoneisia. “Dari apa yang disampaikan oleh Sekjen IJTI Sumetera Selatan tentang visi misi IJTI saya harap para anggota Ikatan Jurnalis Televisi Indonesia Kabupaten OKU Timur yang sudah dilantik pada malam hari ini untuk terus senantiasa menjalankan visi misinya, karena seluruh visi dan misi dari IJTI ini dapat sangat membantu dalam mendukung kemajuan di Kabupaten OKU Timur” tuturnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Saya Ucapkan Selamat bertugas Kepada Elvandri dan seluruh anggota IJTI Kabupaten OKU Timur yang telah dilantik, semoga selalu senantiasa dapat berkontribusi dalam mewujudkan Visi dan Misi Kabupaten OKU Timur Maju Lebih Mulia” Tutup Bupati OKU Timur.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Ketua IJTI Kabupaten OKU Timur Elvandri Jefriadi dalam sambutannya menyampaikan rasa terimakasih kepada Bupati OKU Timur karena sudah mendukung terlaksananya kegiatan Pelatikan Kepengurusan IJTI Kabupaten OKU Timur. Beliau juga menyampaikan rasa bangganya karena memiliki Bupati Enos yang sangat bersahabat dengan seluruh rekan media terutama dengan jurnalis televisi di OKU Timur.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">“Kedepannya kami akan terus mempersembahkan menjadi mitra terbaik bagi pemerintah OKU Timur untuk memberikan berita yang positif demi kemajuan OKU” tutupnya.</p><p style="color: rgb(51, 51, 51); font-family: Roboto, Arial, Helvetica, sans-serif; font-size: 15px;">Tim Diskominfo</p>',
                'published_at' => '2024-09-26',
            ],
        ];
        
        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
