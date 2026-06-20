<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th {
      background-color: #f1f5f9;
      color: #000000;
      font-weight: bold;
      border: 1px solid #cbd5e1;
      padding: 8px;
      text-align: center;
    }
    td {
      border: 1px solid #cbd5e1;
      padding: 8px;
      vertical-align: top;
    }
    .text-center {
      text-align: center;
    }
    .text-right {
      text-align: right;
    }
    .font-bold {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>No.</th>
        <th>No Daftar</th>
        <th>Gelombang</th>
        <th>Status Pendaftaran</th>
        <th>Nama Lengkap</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Agama</th>
        <th>No. HP Siswa</th>
        <th>Asal Sekolah</th>
        <th>Alamat Sekolah</th>
        <th>Prestasi</th>
        <th>Nama Orang Tua / Wali</th>
        <th>Pekerjaan Orang Tua</th>
        <th>No. HP Orang Tua</th>
        <th>Alamat Lengkap</th>
        <th>Pilihan Jurusan 1</th>
        <th>Pilihan Jurusan 2</th>
        <th>Pilihan Jurusan 3</th>
        <th>Tinggi Badan (cm)</th>
        <th>Berat Badan (kg)</th>
        <th>Riwayat Penyakit</th>
        <th>Tato</th>
        <th>Tindik</th>
        <th>Buta Warna</th>
        <th>Catatan Kesehatan</th>
        <th>Tipe Gaya Belajar</th>
        <th>Minat Bakat / Hobi</th>
        <th>Catatan Gaya Belajar</th>
        <th>Kemampuan Baca Quran</th>
        <th>Kedisiplinan Sholat 5 Waktu</th>
        <th>Pengamatan Kepribadian</th>
        <th>Catatan Wawancara</th>
        <th>Petugas Pewawancara (Sistem)</th>
        <th>Nominal SPP (Rp)</th>
        <th>Dana Awal Tahun (Rp)</th>
        <th>Nominal Infaq (Rp)</th>
        <th>Potongan Subsidi (Rp)</th>
        <th>Total Tagihan (Rp)</th>
        <th>Total Terbayar (Rp)</th>
        <th>Sisa Tagihan (Rp)</th>
        <th>Status Pembayaran</th>
        <th>Program Keahlian Diterima</th>
        <th>Ukuran Seragam</th>
      </tr>
    </thead>
    <tbody>
      @foreach($pendaftarans as $index => $p)
      <tr>
        <td class="text-center">{{ $index + 1 }}</td>
        <td class="font-bold text-center">{{ $p->no_daftar }}</td>
        <td>{{ $p->gelombang }}</td>
        <td class="text-center">{{ ucfirst($p->status) }}</td>
        <td class="font-bold">{{ $p->nama_lengkap }}</td>
        <td>{{ $p->tempat_lahir }}</td>
        <td class="text-center">{{ $p->tanggal_lahir ? $p->tanggal_lahir->format('d-m-Y') : '-' }}</td>
        <td class="text-center">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
        <td class="text-center">{{ $p->agama }}</td>
        <td>{{ $p->no_hp_siswa }}</td>
        <td>{{ $p->asal_sekolah }}</td>
        <td>{{ $p->alamat_sekolah }}</td>
        <td>{{ $p->prestasi }}</td>
        <td>{{ $p->nama_ortu }}</td>
        <td>{{ $p->pekerjaan_ortu }}</td>
        <td>{{ $p->no_hp_ortu }}</td>
        <td>
          {{ $p->jalan_asal }} RT {{ $p->rt_asal }}/RW {{ $p->rw_asal ?? '-' }}, 
          Desa {{ $p->desa_asal }}, Kec. {{ $p->kecamatan_asal }}, 
          {{ $p->kabupaten_asal }}, {{ $p->provinsi_asal }}
        </td>
        <td class="text-center font-bold">{{ $p->pil1 }}</td>
        <td class="text-center">{{ $p->pil2 }}</td>
        <td class="text-center">{{ $p->pil3 }}</td>
        <td class="text-center">{{ $p->kesehatan_tinggi_badan ?? '-' }}</td>
        <td class="text-center">{{ $p->kesehatan_berat_badan ?? '-' }}</td>
        <td>{{ $p->kesehatan_penyakit ?? '-' }}</td>
        <td class="text-center">{{ ucfirst($p->kesehatan_tato_tindik ?? '-') }}</td>
        <td class="text-center">{{ ucfirst($p->kesehatan_buta_warna ?? '-') }}</td>
        <td>{{ $p->kesehatan_catatan ?? '-' }}</td>
        <td class="text-center font-bold">{{ ucfirst($p->gaya_belajar_tipe ?? '-') }}</td>
        <td>{{ $p->gaya_belajar_minat_bakat ?? '-' }}</td>
        <td>{{ $p->gaya_belajar_catatan ?? '-' }}</td>
        <td>{{ $p->wawancara_baca_tulis_alquran ?? '-' }}</td>
        <td>{{ $p->wawancara_solat_fardhu ?? '-' }}</td>
        <td>{{ $p->wawancara_kepribadian ?? '-' }}</td>
        <td>{{ $p->wawancara_catatan ?? '-' }}</td>
        <td>{{ $p->petugasWawancara ? $p->petugasWawancara->nama : ($p->wawancara_petugas ?? '-') }}</td>
        <td class="text-right">{{ (int) $p->biaya_spp }}</td>
        <td class="text-right">{{ (int) $p->biaya_dana_awal_tahun }}</td>
        <td class="text-right">{{ (int) $p->biaya_infaq }}</td>
        <td class="text-right">{{ (int) $p->biaya_potongan }}</td>
        <td class="text-right font-bold">{{ (int) $p->total_tagihan }}</td>
        <td class="text-right">{{ (int) $p->total_terbayar }}</td>
        <td class="text-right">{{ (int) $p->sisa_tagihan }}</td>
        <td class="text-center font-bold">
          @if($p->status_bayar === 'lunas')
            Lunas
          @elseif($p->status_bayar === 'cicilan')
            Cicilan
          @else
            Belum Bayar
          @endif
        </td>
        <td class="text-center font-bold">{{ $p->diterima_di_jurusan ?? '-' }}</td>
        <td class="text-center font-bold">{{ $p->ukuran_seragam ?? '-' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
