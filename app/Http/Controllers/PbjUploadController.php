<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PbjUploadController extends Controller
{
    public function create()
    {
        return view('pilihpengadaan');
    }

    public function store(Request $request)
    {
        // Validasi input dari form pengadaan
        $validated = $request->validate([
            'no_kontrak'       => 'required|string|max:255',
            'judul_kontrak'    => 'required|string|max:255',
            'tanggal_kontrak'  => 'required|date',
            'jangka_mulai'     => 'required|date',
            'jangka_akhir'     => 'required|date|after_or_equal:jangka_mulai',
            'vendor_pelaksana' => 'required|string|max:255',
            'nilai_kontrak'    => 'required|numeric',
            'dokumen'          => 'required|file|mimes:pdf|max:2048',
        ]);

        // Hitung jangka waktu dalam hari
        $tanggalMulai = Carbon::parse($validated['jangka_mulai']);
        $tanggalAkhir = Carbon::parse($validated['jangka_akhir']);
        $jangkaWaktu = $tanggalMulai->diffInDays($tanggalAkhir);

        $file = $request->file('dokumen');
        $dokumenPath = $file->store('temp_dokumen');

        // Ambil data dari session sebelumnya (form RENEV)
        $formData = session('form_data');

        if (!$formData || !isset($formData['unsur'], $formData['fungsi'], $formData['no_prk'])) {
            return redirect()->back()->withErrors('Data RENEV belum lengkap atau belum dipilih.');
        }

        $dataBaru = array_merge($validated, [
            'unsur'         => $formData['unsur'],
            'fungsi'        => $formData['fungsi'],
            'no_prk'        => $formData['no_prk'],
            'dokumen'       => $dokumenPath,
            'dokumen_name'  => $file->getClientOriginalName(),
            'jangka_waktu'  => $jangkaWaktu, // <- disimpan ke session
        ]);

        $dataLama = session('data_pbj', []);
        session(['data_pbj' => [...$dataLama, $dataBaru]]);

        return redirect()->route('hasil.pengadaan');
    }

    public function index()
    {
        $data_pbj = session('data_pbj', []);
        return view('hasilpengadaan', compact('data_pbj'));
    }

    public function download($filename)
    {
        $path = storage_path('app/temp_dokumen/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path);
    }
    
}
