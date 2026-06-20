<?php

namespace App\Http\Controllers;

use App\Models\NoboxSetting;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminNoboxController extends Controller
{
    /**
     * Tampilkan form pengaturan WhatsApp Fonnte.
     */
    public function edit()
    {
        $setting = NoboxSetting::getSingle();
        return view('admin.nobox.edit', compact('setting'));
    }

    /**
     * Simpan perubahan pengaturan WhatsApp Fonnte.
     */
    public function update(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ], [
            'api_key.required' => 'Token Fonnte wajib diisi.',
        ]);

        $setting = NoboxSetting::getSingle();
        $setting->update([
            'api_key'     => $request->api_key,
            'otp_via_log' => $request->has('otp_via_log'),
        ]);

        return redirect()->route('admin.nobox.edit')
            ->with('success', 'Pengaturan WhatsApp Fonnte berhasil diperbarui!');
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
            $service = new FonnteService();
            $success = $service->sendMessage($request->test_phone, $request->test_message);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan uji coba WhatsApp berhasil dikirim! Silakan periksa nomor tujuan.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan uji coba. Pastikan Token Fonnte Anda valid dan nomor tujuan terdaftar.',
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
