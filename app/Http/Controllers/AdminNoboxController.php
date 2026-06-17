<?php

namespace App\Http\Controllers;

use App\Models\NoboxSetting;
use App\Services\NoboxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminNoboxController extends Controller
{
    /**
     * Tampilkan form pengaturan Nobox.
     */
    public function edit()
    {
        $setting = NoboxSetting::getSingle();
        return view('admin.nobox.edit', compact('setting'));
    }

    /**
     * Simpan perubahan pengaturan Nobox.
     */
    public function update(Request $request)
    {
        $request->validate([
            'account_ids' => 'required|string',
            'api_key'     => 'required|string',
            'channel_id'  => 'required|string',
            'url'         => 'required|url',
        ], [
            'account_ids.required' => 'Account ID wajib diisi.',
            'api_key.required'     => 'API Key (x-api-key) wajib diisi.',
            'channel_id.required'  => 'Channel ID wajib diisi.',
            'url.required'         => 'Gateway URL wajib diisi.',
            'url.url'              => 'Gateway URL harus format URL yang valid.',
        ]);

        $setting = NoboxSetting::getSingle();
        $setting->update([
            'account_ids' => $request->account_ids,
            'api_key'     => $request->api_key,
            'channel_id'  => $request->channel_id,
            'url'         => $request->url,
            'otp_via_log' => $request->has('otp_via_log'),
        ]);

        return redirect()->route('admin.nobox.edit')
            ->with('success', 'Pengaturan Nobox berhasil diperbarui!');
    }

    /**
     * Kirim pesan uji coba WhatsApp.
     */
    public function testSend(Request $request)
    {
        $request->validate([
            'test_phone'   => 'required|string|min:10|max:15',
            'test_message' => 'required|string|max:500',
        ], [
            'test_phone.required'   => 'Nomor telepon tujuan wajib diisi.',
            'test_phone.min'        => 'Nomor telepon minimal 10 digit.',
            'test_message.required' => 'Isi pesan uji coba wajib diisi.',
        ]);

        try {
            // Kita inisialisasi NoboxService. Ia akan mengambil data terbaru yang tersimpan di DB
            $service = new NoboxService();
            $success = $service->sendMessage($request->test_phone, $request->test_message);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan uji coba WhatsApp berhasil dikirim! Silakan periksa nomor tujuan.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan uji coba. Periksa log Laravel atau pastikan konfigurasi API Key dan Account ID sudah benar.',
            ], 400);

        } catch (\Exception $e) {
            Log::error('AdminNoboxController: Test send exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
            ], 500);
        }
    }
}
