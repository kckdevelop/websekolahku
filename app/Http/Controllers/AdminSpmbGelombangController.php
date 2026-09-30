<?php
 
namespace App\Http\Controllers;

use App\Models\SpmbGelombang;
use App\Models\SpmbPageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AdminSpmbGelombangController extends Controller
{
    /**
     * Dapatkan daftar gelombang secara aman dengan urutan yang fleksibel.
     */
    private function getGelombangs()
    {
        $hasTanggalMulai = Schema::hasColumn('spmb_gelombangs', 'tanggal_mulai');
        $orderCol = $hasTanggalMulai ? 'tanggal_mulai' : (Schema::hasColumn('spmb_gelombangs', 'tanggal_buka') ? 'tanggal_buka' : 'id');
        return SpmbGelombang::orderBy($orderCol, 'asc')->get();
    }

    /**
     * Siapkan payload data sesuai kolom yang tersedia di database.
     */
    private function prepareData(Request $request): array
    {
        $data = [
            'nama_gelombang'      => $request->nama_gelombang,
            'kode_gelombang'      => $request->kode_gelombang,
            'keterangan'          => $request->keterangan,
            'biaya_pendaftaran'   => $request->biaya_pendaftaran ?? 0,
            'biaya_zakat_default' => $request->biaya_zakat_default ?? 0,
            'potongan_subsidi'    => $request->potongan_subsidi ?? 0,
        ];

        if (Schema::hasColumn('spmb_gelombangs', 'tahun_ajaran')) {
            $data['tahun_ajaran'] = $request->tahun_ajaran;
        }

        if (Schema::hasColumn('spmb_gelombangs', 'tanggal_mulai')) {
            $data['tanggal_mulai'] = $request->tanggal_mulai;
        }
        if (Schema::hasColumn('spmb_gelombangs', 'tanggal_selesai')) {
            $data['tanggal_selesai'] = $request->tanggal_selesai;
        }

        // Fallback untuk tabel yang masih menggunakan nama kolom lama (tanggal_buka / tanggal_tutup)
        if (Schema::hasColumn('spmb_gelombangs', 'tanggal_buka')) {
            $data['tanggal_buka'] = $request->tanggal_mulai ?? now()->toDateString();
        }
        if (Schema::hasColumn('spmb_gelombangs', 'tanggal_tutup')) {
            $data['tanggal_tutup'] = $request->tanggal_selesai ?? now()->addMonths(3)->toDateString();
        }

        return $data;
    }

    /**
     * Tampilkan daftar gelombang pendaftaran.
     */
    public function index()
    {
        $gelombangs = $this->getGelombangs();
        $isPendaftaranOpen = SpmbPageContent::getSingle()->is_pendaftaran_open;
        return view('admin.gelombang.index', compact('gelombangs', 'isPendaftaranOpen'));
    }

    /**
     * Simpan gelombang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_gelombang'     => 'required|string|max:100',
            'kode_gelombang'     => 'required|integer|min:1|max:99',
            'tahun_ajaran'       => 'required|string|max:20',
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'         => 'nullable|string|max:255',
            'biaya_pendaftaran'  => 'nullable|numeric|min:0',
            'biaya_zakat_default'=> 'nullable|numeric|min:0',
            'potongan_subsidi'   => 'nullable|numeric|min:0',
        ], [
            'nama_gelombang.required'  => 'Nama gelombang wajib diisi.',
            'kode_gelombang.required'  => 'Kode gelombang wajib diisi.',
            'kode_gelombang.integer'   => 'Kode gelombang harus berupa angka.',
            'kode_gelombang.min'       => 'Kode gelombang minimal 1.',
            'tahun_ajaran.required'    => 'Tahun ajaran wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        try {
            $isFirst = SpmbGelombang::count() === 0;
            $shouldBeActive = $isFirst || $request->has('is_aktif');

            $data = $this->prepareData($request);
            $data['is_aktif'] = false;

            $gelombang = SpmbGelombang::create($data);

            if ($shouldBeActive) {
                $gelombang->activate();
            }

            return redirect()->route('admin.gelombang.index')
                ->with('success', 'Gelombang pendaftaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error storing SPMB Gelombang: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan gelombang: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit gelombang.
     */
    public function edit(SpmbGelombang $gelombang)
    {
        $gelombangs = $this->getGelombangs();
        $isPendaftaranOpen = SpmbPageContent::getSingle()->is_pendaftaran_open;
        return view('admin.gelombang.index', compact('gelombangs', 'gelombang', 'isPendaftaranOpen'));
    }

    /**
     * Update data gelombang.
     */
    public function update(Request $request, SpmbGelombang $gelombang)
    {
        $request->validate([
            'nama_gelombang'     => 'required|string|max:100',
            'kode_gelombang'     => 'required|integer|min:1|max:99',
            'tahun_ajaran'       => 'required|string|max:20',
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'         => 'nullable|string|max:255',
            'biaya_pendaftaran'  => 'nullable|numeric|min:0',
            'biaya_zakat_default'=> 'nullable|numeric|min:0',
            'potongan_subsidi'   => 'nullable|numeric|min:0',
        ], [
            'nama_gelombang.required'  => 'Nama gelombang wajib diisi.',
            'kode_gelombang.required'  => 'Kode gelombang wajib diisi.',
            'kode_gelombang.integer'   => 'Kode gelombang harus berupa angka.',
            'kode_gelombang.min'       => 'Kode gelombang minimal 1.',
            'tahun_ajaran.required'    => 'Tahun ajaran wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ]);

        try {
            $data = $this->prepareData($request);
            $gelombang->update($data);

            if ($request->has('is_aktif')) {
                $gelombang->activate();
            }

            return redirect()->route('admin.gelombang.index')
                ->with('success', 'Gelombang pendaftaran berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating SPMB Gelombang: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui gelombang: ' . $e->getMessage());
        }
    }

    /**
     * Hapus gelombang pendaftaran.
     */
    public function destroy(SpmbGelombang $gelombang)
    {
        try {
            $wasActive = $gelombang->is_aktif;
            $gelombang->delete();

            // Jika yang dihapus aktif, aktifkan gelombang lain yang ada (jika ada)
            if ($wasActive) {
                $nextActive = SpmbGelombang::first();
                if ($nextActive) {
                    $nextActive->activate();
                }
            }

            return redirect()->route('admin.gelombang.index')
                ->with('success', 'Gelombang pendaftaran berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting SPMB Gelombang: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('admin.gelombang.index')
                ->with('error', 'Gagal menghapus gelombang: ' . $e->getMessage());
        }
    }

    /**
     * Ubah gelombang aktif secara langsung.
     */
    public function toggleActive(SpmbGelombang $gelombang)
    {
        try {
            $gelombang->activate();

            return redirect()->route('admin.gelombang.index')
                ->with('success', 'Gelombang "' . $gelombang->nama_gelombang . '" sekarang menjadi gelombang aktif!');
        } catch (\Exception $e) {
            Log::error('Error activating SPMB Gelombang: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('admin.gelombang.index')
                ->with('error', 'Gagal mengaktifkan gelombang: ' . $e->getMessage());
        }
    }
}
