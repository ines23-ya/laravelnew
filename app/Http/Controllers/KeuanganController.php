<?php

namespace App\Http\Controllers;

use App\Models\Renev;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel Renev, Pengadaan, dan Kontruksi dengan relasi
        $renevs = Renev::with(['pengadaan', 'kontruksi'])->get();  // Mengambil relasi langsung

        
        // Gabungkan data untuk dikirim ke tampilan (keuangan)
        $data_keuangan = $renevs->map(function ($reneve) {
            return [
                'no_prk'        => $reneve->no_prk,
                'no_kontrak'    => $reneve->pengadaan->no_kontrak ?? '-',  // Ambil no_kontrak dari relasi Pengadaan
                'judul_kontrak' => $reneve->pengadaan->judul_kontrak ?? '-',  // Ambil judul_kontrak dari Pengadaan
                'pekerjaan'     => $reneve->kontruksi->pekerjaan ?? '-',  // Ambil pekerjaan dari Kontruksi
                'nilai'         => $reneve->pengadaan->nilai_kontrak ?? 0,  // Ambil nilai kontrak dari Pengadaan
                'jangka_waktu'  => $reneve->pengadaan->jangka_waktu ?? '-',  // Ambil jangka waktu dari Pengadaan
                'progres'       => $reneve->kontruksi->progres ?? 0,  // Ambil progres dari Kontruksi
                'bp_lkp'        => $reneve->kontruksi->bp_lkp ?? null,  // Ambil bp_lkp dari Kontruksi
                'bp_st'         => $reneve->kontruksi->bp_st ?? null,  // Ambil bp_st dari Kontruksi
                'bp_pp'         => $reneve->kontruksi->bp_pp ?? null,  // Ambil bp_pp dari Kontruksi
                'keterangan'    => $reneve->kontruksi->keterangan ?? '-',  // Ambil keterangan dari Kontruksi
            ];
        });

        // Kirimkan data ke tampilan keuangan
        return view('keuangan', ['data_keuangan' => $data_keuangan]);
    }




    public function upload(Request $request)
    {
        // Validasi input progres_pembayaran
        $validated = $request->validate([
            'progres_pembayaran' => 'required|numeric|min:0|max:100',
        ]);

        // Menyimpan data progres_pembayaran ke session
        session(['form_data.progres_pembayaran' => $validated['progres_pembayaran']]);

        // Redirect dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Progres pembayaran berhasil diupdate.');
    }
}
