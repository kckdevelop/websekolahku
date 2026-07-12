<?php

namespace Database\Seeders;

use App\Models\TefaProduct;
use App\Models\JurusanContent;
use App\Models\TefaSetting;
use Illuminate\Database\Seeder;

class TefaDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed or Initialize Tefa settings
        $setting = TefaSetting::getSingle();
        $setting->update([
            'hero_title' => 'Teaching Factory (Tefa)',
            'hero_subtitle' => 'Mengembangkan Produk & Jasa Unggulan Berstandar Industri di SMK Muhammadiyah 1 Bantul',
            'tentang_judul' => 'Mengenal Teaching Factory SMK Muhammadiyah 1 Bantul',
            'tentang_deskripsi' => "Teaching Factory (Tefa) SMK Muhammadiyah 1 Bantul merupakan model pembelajaran berbasis industri yang menyelaraskan kurikulum sekolah dengan kebutuhan industri nyata.\n\nMelalui program ini, siswa terlibat langsung dalam memproduksi produk dan melaksanakan jasa yang dipesan oleh masyarakat umum maupun mitra industri. Pembelajaran ini didampingi oleh guru produktif dan instruktur industri berpengalaman guna menjamin standar kualitas kerja professional.",
            'telepon_wa' => '6281234567890',
        ]);

        // 2. Clear existing products to avoid duplicates
        TefaProduct::truncate();

        // 3. Define dummy products per jurusan slug
        $dummyData = [
            'tkr' => [
                [
                    'nama' => 'Jasa Tune-up & Service Mobil Ringan',
                    'deskripsi' => 'Perawatan mesin mobil berkala mencakup pembersihan busi, filter udara, karburator/throttle body, cek rem, dan ganti oli mesin.',
                    'harga' => 150000,
                    'aktif' => true,
                    'urutan' => 1,
                ],
                [
                    'nama' => 'Spooring & Balancing Presisi',
                    'deskripsi' => 'Meluruskan keselarasan roda kendaraan agar laju mobil stabil dan nyaman serta memperpanjang masa pakai ban.',
                    'harga' => 100000,
                    'aktif' => true,
                    'urutan' => 2,
                ],
                [
                    'nama' => 'Cuci Mobil & Detailing Eksterior',
                    'deskripsi' => 'Pencucian body mobil dengan sampo wax berkualitas tinggi, pembersihan interior, dan poles kaca anti jamur.',
                    'harga' => 50000,
                    'aktif' => true,
                    'urutan' => 3,
                ]
            ],
            'tbsm' => [
                [
                    'nama' => 'Paket Service Ringan + Oli Motor',
                    'deskripsi' => 'Service rutin sepeda motor bebek atau matic, stel rantai, cek kelistrikan, pembersihan karburator/injeksi, gratis oli berkualitas.',
                    'harga' => 55000,
                    'aktif' => true,
                    'urutan' => 1,
                ],
                [
                    'nama' => 'Jasa Overhaul & Turun Mesin',
                    'deskripsi' => 'Perbaikan total mesin motor yang berasap atau hilang tenaga. Dikerjakan dengan sparepart asli bergaransi.',
                    'harga' => 180000,
                    'aktif' => true,
                    'urutan' => 2,
                ],
                [
                    'nama' => 'Instalasi Kelistrikan & Lampu LED',
                    'deskripsi' => 'Pemasangan variasi kelistrikan, alarm pengaman, lampu utama LED projector, dan penataan kabel rapi standar pabrik.',
                    'harga' => 75000,
                    'aktif' => true,
                    'urutan' => 3,
                ]
            ],
            'tpm' => [
                [
                    'nama' => 'Jasa Pembubutan & Milling Presisi',
                    'deskripsi' => 'Melayani pembuatan poros, gigi roda, mur, baut kustom, dan pengerjaan logam dengan toleransi ukuran yang sangat ketat menggunakan mesin bubut industri.',
                    'harga' => null,
                    'aktif' => true,
                    'urutan' => 1,
                ],
                [
                    'nama' => 'Pembuatan Pagar & Kanopi Minimalis',
                    'deskripsi' => 'Fabrikasi pagar, pintu lipat, teralis jendela, dan kanopi rangka besi hollow antikarat. Harga per meter persegi.',
                    'harga' => 350000,
                    'aktif' => true,
                    'urutan' => 2,
                ],
                [
                    'nama' => 'Rak Display Toko Besi Hollow',
                    'deskripsi' => 'Rak display pajangan pajang serbaguna untuk minimarket atau toko. Rangka besi hollow kokoh dilapisi cat powder coating.',
                    'harga' => 250000,
                    'aktif' => true,
                    'urutan' => 3,
                ]
            ],
            'tav' => [
                [
                    'nama' => 'Service TV LED / LCD & Monitor',
                    'deskripsi' => 'Perbaikan TV mati total, layar gelap suara ada, ganti backlight LED, dan kerusakan power supply serta mainboard.',
                    'harga' => 120000,
                    'aktif' => true,
                    'urutan' => 1,
                ],
                [
                    'nama' => 'Perakitan & Custom Sound System',
                    'deskripsi' => 'Pembuatan sound system ruangan atau lapangan (Power Amplifier, Crossover, Mixer) dengan spesifikasi kustom berkualitas tinggi.',
                    'harga' => null,
                    'aktif' => true,
                    'urutan' => 2,
                ],
                [
                    'nama' => 'Instalasi Audio & Kamera Mundur Mobil',
                    'deskripsi' => 'Pemasangan head unit android layar sentuh, sound system speaker subwoofer mobil, dan kamera parkir mundur.',
                    'harga' => 200000,
                    'aktif' => true,
                    'urutan' => 3,
                ]
            ],
            'rpl' => [
                [
                    'nama' => 'Jasa Pembuatan Website Profile Perusahaan / Sekolah',
                    'deskripsi' => 'Pembuatan website profesional responsif berbasis Laravel/WordPress lengkap dengan hosting, domain, halaman admin, dan sertifikat SSL.',
                    'harga' => 1500000,
                    'aktif' => true,
                    'urutan' => 1,
                ],
                [
                    'nama' => 'Aplikasi Kasir Point of Sale (POS) Android',
                    'deskripsi' => 'Aplikasi pencatatan stok barang, transaksi penjualan, cetak struk thermal via bluetooth, dan laporan keuangan digital.',
                    'harga' => 2000000,
                    'aktif' => true,
                    'urutan' => 2,
                ],
                [
                    'nama' => 'Desain Landing Page & UI/UX Desain',
                    'deskripsi' => 'Pembuatan rancangan mockup user interface aplikasi mobile atau website menggunakan Figma lengkap dengan aset-aset desain siap pakai.',
                    'harga' => 500000,
                    'aktif' => true,
                    'urutan' => 3,
                ]
            ]
        ];

        // 4. Insert Tefa products for each jurusan
        foreach ($dummyData as $slug => $products) {
            $jurusan = JurusanContent::where('slug', $slug)->first();
            $jurusanId = $jurusan ? $jurusan->id : null;

            foreach ($products as $prod) {
                TefaProduct::create(array_merge($prod, [
                    'jurusan_content_id' => $jurusanId
                ]));
            }
        }

        // 5. Insert general/common Tefa products (tidak terikat jurusan)
        TefaProduct::create([
            'nama' => 'Jasa Cetak 3D Model Filamen PLA',
            'deskripsi' => 'Menerima file desain 3D (.STL/.OBJ) untuk dicetak fisik menggunakan mesin 3D printer presisi tinggi. Pilihan warna filamen beragam.',
            'harga' => 50000,
            'aktif' => true,
            'urutan' => 1,
            'jurusan_content_id' => null,
        ]);

        TefaProduct::create([
            'nama' => 'Penyewaan Ruang Aula Serbaguna Sekolah',
            'deskripsi' => 'Disewakan untuk acara hajatan pernikahan, seminar, rapat organisasi, lengkap dengan sound system standar panggung dan AC standing.',
            'harga' => 1000000,
            'aktif' => true,
            'urutan' => 2,
            'jurusan_content_id' => null,
        ]);
    }
}
