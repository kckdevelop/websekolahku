<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use ZipArchive;

class AdminDownloadPendaftaranController extends Controller
{
    /**
     * All column group definitions.
     * Each group has an id, label, icon, and list of [header => field_closure].
     */
    private function columnGroups(): array
    {
        return [
            'pendaftaran' => [
                'label' => 'Data Pendaftaran',
                'icon'  => 'fas fa-id-card',
                'color' => '#f97316',
                'cols'  => [
                    'No. Daftar'   => fn($p) => $p->no_daftar ?? '',
                    'Gelombang'    => fn($p) => $p->gelombang ?? '',
                    'Tahun Aktif'  => fn($p) => $p->tahun_aktif ?? '',
                    'Status'       => fn($p) => ucfirst($p->status ?? ''),
                    'Tgl. Daftar'  => fn($p) => $p->created_at ? $p->created_at->format('d/m/Y H:i') : '',
                ],
            ],
            'pribadi' => [
                'label' => 'Data Pribadi',
                'icon'  => 'fas fa-user',
                'color' => '#3b82f6',
                'cols'  => [
                    'Nama Lengkap'  => fn($p) => $p->nama_lengkap ?? '',
                    'Tempat Lahir'  => fn($p) => $p->tempat_lahir ?? '',
                    'Tanggal Lahir' => fn($p) => $p->tanggal_lahir ? $p->tanggal_lahir->format('d/m/Y') : '',
                    'Jenis Kelamin' => fn($p) => $p->jenis_kelamin === 'L' ? 'Laki-laki' : ($p->jenis_kelamin === 'P' ? 'Perempuan' : ($p->jenis_kelamin ?? '')),
                    'Agama'         => fn($p) => $p->agama ?? '',
                    'No HP Siswa'   => fn($p) => $p->no_hp_siswa ?? '',
                ],
            ],
            'sekolah' => [
                'label' => 'Asal Sekolah',
                'icon'  => 'fas fa-school',
                'color' => '#8b5cf6',
                'cols'  => [
                    'Asal Sekolah'   => fn($p) => $p->asal_sekolah ?? '',
                    'Alamat Sekolah' => fn($p) => $p->alamat_sekolah ?? '',
                    'Prestasi'       => fn($p) => $p->prestasi ?? '',
                ],
            ],
            'ortu' => [
                'label' => 'Orang Tua',
                'icon'  => 'fas fa-users',
                'color' => '#ec4899',
                'cols'  => [
                    'Nama Orang Tua'    => fn($p) => $p->nama_ortu ?? '',
                    'Pekerjaan Ortu'    => fn($p) => $p->pekerjaan_ortu ?? '',
                    'No HP Orang Tua'   => fn($p) => $p->no_hp_ortu ?? '',
                ],
            ],
            'alamat' => [
                'label' => 'Alamat',
                'icon'  => 'fas fa-map-marker-alt',
                'color' => '#14b8a6',
                'cols'  => [
                    'Jalan Asal'       => fn($p) => $p->jalan_asal ?? '',
                    'Dusun Asal'       => fn($p) => $p->dusun_asal ?? '',
                    'RT/RW Asal'       => fn($p) => ($p->rt_asal ?? '') . ($p->rw_asal ? '/' . $p->rw_asal : ''),
                    'Desa Asal'        => fn($p) => $p->desa_asal ?? '',
                    'Kecamatan Asal'   => fn($p) => $p->kecamatan_asal ?? '',
                    'Kabupaten Asal'   => fn($p) => $p->kabupaten_asal ?? '',
                    'Provinsi Asal'    => fn($p) => $p->provinsi_asal ?? '',
                    'Jalan Tinggal'    => fn($p) => $p->jalan_tinggal ?? '',
                    'Dusun Tinggal'    => fn($p) => $p->dusun_tinggal ?? '',
                    'RT/RW Tinggal'    => fn($p) => ($p->rt_tinggal ?? '') . ($p->rw_tinggal ? '/' . $p->rw_tinggal : ''),
                    'Desa Tinggal'     => fn($p) => $p->desa_tinggal ?? '',
                    'Kecamatan Tinggal'=> fn($p) => $p->kecamatan_tinggal ?? '',
                    'Kabupaten Tinggal'=> fn($p) => $p->kabupaten_tinggal ?? '',
                    'Provinsi Tinggal' => fn($p) => $p->provinsi_tinggal ?? '',
                ],
            ],
            'jurusan' => [
                'label' => 'Pilihan Jurusan',
                'icon'  => 'fas fa-graduation-cap',
                'color' => '#f59e0b',
                'cols'  => [
                    'Pilihan 1'          => fn($p) => $p->pil1 ?? '',
                    'Pilihan 2'          => fn($p) => $p->pil2 ?? '',
                    'Pilihan 3'          => fn($p) => $p->pil3 ?? '',
                    'Diterima di Jurusan'=> fn($p) => $p->diterima_di_jurusan ?? '',
                    'Ukuran Seragam'     => fn($p) => $p->ukuran_seragam ?? '',
                ],
            ],
            'kesehatan' => [
                'label' => 'Kesehatan',
                'icon'  => 'fas fa-heartbeat',
                'color' => '#ef4444',
                'cols'  => [
                    'Tinggi Badan (cm)'      => fn($p) => $p->kesehatan_tinggi_badan ?? '',
                    'Berat Badan (kg)'       => fn($p) => $p->kesehatan_berat_badan ?? '',
                    'Golongan Darah'         => fn($p) => $p->kesehatan_golongan_darah ?? '',
                    'Buta Warna'             => fn($p) => $p->kesehatan_buta_warna ?? '',
                    'Mata Minus'             => fn($p) => $p->kesehatan_mata_minus ?? '',
                    'Tato/Tindik'            => fn($p) => $p->kesehatan_tato_tindik ?? '',
                    'Riwayat Penyakit'       => fn($p) => $p->kesehatan_riwayat_penyakit ?? '',
                    'Catatan Kesehatan'      => fn($p) => $p->kesehatan_catatan ?? '',
                    'Petugas Kesehatan'      => fn($p) => $p->kesehatan_petugas ?? '',
                    'Tgl. Verif. Kesehatan'  => fn($p) => $p->kesehatan_verified_at ? $p->kesehatan_verified_at->format('d/m/Y H:i') : '',
                ],
            ],
            'gaya_belajar' => [
                'label' => 'Gaya Belajar',
                'icon'  => 'fas fa-brain',
                'color' => '#a855f7',
                'cols'  => [
                    'Tipe Gaya Belajar'        => fn($p) => $p->gaya_belajar_tipe ?? '',
                    'Minat Bakat'              => fn($p) => $p->gaya_belajar_minat_bakat ?? '',
                    'Catatan Gaya Belajar'     => fn($p) => $p->gaya_belajar_catatan ?? '',
                    'Petugas Gaya Belajar'     => fn($p) => $p->gaya_belajar_petugas ?? '',
                    'Tgl. Verif. Gaya Belajar' => fn($p) => $p->gaya_belajar_verified_at ? $p->gaya_belajar_verified_at->format('d/m/Y H:i') : '',
                ],
            ],
            'wawancara' => [
                'label' => 'Wawancara',
                'icon'  => 'fas fa-comments',
                'color' => '#06b6d4',
                'cols'  => [
                    'Baca Tulis Al-Quran'    => fn($p) => $p->wawancara_baca_tulis_alquran ?? '',
                    'Sholat Fardhu'          => fn($p) => $p->wawancara_solat_fardhu ?? '',
                    'Kepribadian'            => fn($p) => $p->wawancara_kepribadian ?? '',
                    'Catatan Wawancara'      => fn($p) => $p->wawancara_catatan ?? '',
                    'Pewawancara'            => fn($p) => $p->petugasWawancara ? $p->petugasWawancara->nama : ($p->wawancara_petugas ?? ''),
                    'Tgl. Verif. Wawancara'  => fn($p) => $p->wawancara_verified_at ? $p->wawancara_verified_at->format('d/m/Y H:i') : '',
                ],
            ],
            'biaya' => [
                'label' => 'Biaya',
                'icon'  => 'fas fa-money-bill-wave',
                'color' => '#22c55e',
                'cols'  => [
                    'Biaya SPP (Rp)'       => fn($p) => $p->biaya_spp ? number_format((float)$p->biaya_spp, 0, ',', '.') : '',
                    'Dana Awal Tahun (Rp)' => fn($p) => $p->biaya_dana_awal_tahun ? number_format((float)$p->biaya_dana_awal_tahun, 0, ',', '.') : '',
                    'Biaya Infaq (Rp)'     => fn($p) => $p->biaya_infaq ? number_format((float)$p->biaya_infaq, 0, ',', '.') : '',
                    'Potongan (Rp)'        => fn($p) => $p->biaya_potongan ? number_format((float)$p->biaya_potongan, 0, ',', '.') : '',
                    'Total Tagihan (Rp)'   => fn($p) => $p->total_tagihan ? number_format((float)$p->total_tagihan, 0, ',', '.') : '',
                    'Petugas Biaya'        => fn($p) => $p->biaya_petugas ?? '',
                ],
            ],
            'pembayaran' => [
                'label' => 'Pembayaran',
                'icon'  => 'fas fa-credit-card',
                'color' => '#f43f5e',
                'cols'  => [
                    'Total Terbayar (Rp)'     => fn($p) => number_format($p->total_terbayar, 0, ',', '.'),
                    'Sisa Tagihan (Rp)'       => fn($p) => number_format($p->sisa_tagihan, 0, ',', '.'),
                    'Status Bayar'            => fn($p) => ucfirst(str_replace('_', ' ', $p->status_bayar ?? '')),
                    'Keterangan Pembayaran'   => fn($p) => $p->pembayaran_keterangan ?? '',
                    'Petugas Pembayaran'      => fn($p) => $p->pembayaran_petugas ?? '',
                    'Tgl. Verif. Pembayaran'  => fn($p) => $p->pembayaran_verified_at ? $p->pembayaran_verified_at->format('d/m/Y H:i') : '',
                ],
            ],
        ];
    }

    public function index(Request $request)
    {
        $gelombangs    = \App\Models\SpmbGelombang::orderBy('tanggal_mulai', 'asc')->get();
        $totalPendaftar = Pendaftaran::count();
        $groups        = $this->columnGroups();

        // Build preview data (max 10 rows)
        $query = Pendaftaran::with(['riwayatPembayaran', 'petugasWawancara'])
            ->orderBy('created_at', 'asc');

        if ($request->filled('gelombang')) {
            $query->where('gelombang', $request->gelombang);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $totalFiltered = $query->count();
        $previewRows   = $query->limit(10)->get();

        // Selected groups (from request, default all)
        $selectedGroups = $request->filled('groups') ? $request->input('groups') : array_keys($groups);

        return view('admin.download.index', compact(
            'gelombangs', 'totalPendaftar', 'totalFiltered',
            'groups', 'previewRows', 'selectedGroups'
        ));
    }

    public function download(Request $request)
    {
        $groups         = $this->columnGroups();
        $selectedGroups = $request->input('groups', array_keys($groups));

        // Sanitize
        $selectedGroups = array_filter($selectedGroups, fn($g) => isset($groups[$g]));

        $query = Pendaftaran::with(['riwayatPembayaran', 'petugasWawancara'])
            ->orderBy('created_at', 'asc');

        if ($request->filled('gelombang')) {
            $query->where('gelombang', $request->gelombang);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rows = $query->get();

        // Build headers & row closures from selected groups
        $headers  = ['No'];
        $closures = [];

        foreach ($selectedGroups as $gid) {
            foreach ($groups[$gid]['cols'] as $header => $fn) {
                $headers[]  = $header;
                $closures[] = $fn;
            }
        }

        // Build data
        $data = [];
        $no   = 1;
        foreach ($rows as $p) {
            $row = [$no++];
            foreach ($closures as $fn) {
                $row[] = $fn($p);
            }
            $data[] = $row;
        }

        $filename = 'data-pendaftaran-' . date('Ymd-His') . '.xlsx';
        $xlsx     = $this->generateXlsx($headers, $data);

        return response($xlsx, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    private function generateXlsx(array $headers, array $rows): string
    {
        $strings     = [];
        $stringIndex = [];

        $addString = function (string $val) use (&$strings, &$stringIndex): int {
            if (!isset($stringIndex[$val])) {
                $stringIndex[$val] = count($strings);
                $strings[]         = $val;
            }
            return $stringIndex[$val];
        };

        $sheetRows = '';

        // Header row
        $sheetRows .= '<row r="1">';
        foreach ($headers as $ci => $h) {
            $col        = $this->colName($ci);
            $si         = $addString((string) $h);
            $sheetRows .= '<c r="' . $col . '1" t="s"><v>' . $si . '</v></c>';
        }
        $sheetRows .= '</row>';

        // Data rows
        foreach ($rows as $ri => $row) {
            $rowNum     = $ri + 2;
            $sheetRows .= '<row r="' . $rowNum . '">';
            foreach ($row as $ci => $cell) {
                $col        = $this->colName($ci);
                $cell       = (string) $cell;
                if ($ci === 0 && is_numeric($cell)) {
                    $sheetRows .= '<c r="' . $col . $rowNum . '" t="n"><v>' . htmlspecialchars($cell, ENT_XML1) . '</v></c>';
                } else {
                    $si         = $addString($cell);
                    $sheetRows .= '<c r="' . $col . $rowNum . '" t="s"><v>' . $si . '</v></c>';
                }
            }
            $sheetRows .= '</row>';
        }

        $ssXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $ssXml .= '<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . count($strings) . '" uniqueCount="' . count($strings) . '">';
        foreach ($strings as $s) {
            $ssXml .= '<si><t xml:space="preserve">' . htmlspecialchars($s, ENT_XML1, 'UTF-8') . '</t></si>';
        }
        $ssXml .= '</sst>';

        $sheetXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $sheetXml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $sheetXml .= '<sheetData>' . $sheetRows . '</sheetData>';
        $sheetXml .= '</worksheet>';

        $wbXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $wbXml .= '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">';
        $wbXml .= '<sheets><sheet name="Data Pendaftaran" sheetId="1" r:id="rId1"/></sheets>';
        $wbXml .= '</workbook>';

        $wbRelsXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $wbRelsXml .= '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
        $wbRelsXml .= '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>';
        $wbRelsXml .= '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>';
        $wbRelsXml .= '</Relationships>';

        $ctXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $ctXml .= '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">';
        $ctXml .= '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>';
        $ctXml .= '<Default Extension="xml" ContentType="application/xml"/>';
        $ctXml .= '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>';
        $ctXml .= '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
        $ctXml .= '<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>';
        $ctXml .= '</Types>';

        $rootRelsXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $rootRelsXml .= '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
        $rootRelsXml .= '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>';
        $rootRelsXml .= '</Relationships>';

        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx');
        $zip     = new ZipArchive();
        $zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFromString('[Content_Types].xml', $ctXml);
        $zip->addFromString('_rels/.rels', $rootRelsXml);
        $zip->addFromString('xl/workbook.xml', $wbXml);
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wbRelsXml);
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
        $zip->addFromString('xl/sharedStrings.xml', $ssXml);
        $zip->close();

        $content = file_get_contents($tmpFile);
        unlink($tmpFile);
        return $content;
    }

    private function colName(int $index): string
    {
        $col = '';
        $index++;
        while ($index > 0) {
            $mod   = ($index - 1) % 26;
            $col   = chr(65 + $mod) . $col;
            $index = (int) (($index - $mod) / 26);
        }
        return $col;
    }
}
