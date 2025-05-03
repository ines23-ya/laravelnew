<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $data_pbj = session('data_pbj', []);
        $data_kontrak = session('data_kontrak', []);

        $kontrakMap = collect($data_kontrak)->keyBy(function ($item) {
            return strtolower(trim($item['no_kontrak'] ?? ''));
        });

        $finalData = collect($data_pbj)->map(function ($item) use ($kontrakMap) {
            $no_kontrak = strtolower(trim($item['no_kontrak'] ?? ''));


            $kontrakUpdate = $kontrakMap->get($no_kontrak);

            return [
                'no_prk'        => $item['no_prk'] ?? '-',
                'no_kontrak'    => $item['no_kontrak'] ?? '-',
                'judul_kontrak' => $item['judul_kontrak'] ?? '-',
                'pekerjaan'     => $kontrakUpdate['pekerjaan'] ?? $item['judul_kontrak'] ?? '-',
                'nilai'         => $kontrakUpdate['nilai'] ?? $item['nilai_kontrak'] ?? 0,
                'jangka_waktu'  => $item['jangka_waktu'] ?? '-',
                'progres'       => $kontrakUpdate['progres'] ?? 0,
                'bp_lkp'        => $kontrakUpdate['bp_lkp'] ?? null,
                'bp_st'         => $kontrakUpdate['bp_st'] ?? null,
                'bp_pp'         => $kontrakUpdate['bp_pp'] ?? null,
                'keterangan'    => $kontrakUpdate['keterangan'] ?? '-',
            ];
        });

        return view('keuangan', ['data_keuangan' => $finalData]);
    }

    public function upload(Request $request)
    {
        $validated = $request->validate([
            'progres_pembayaran' => 'required|numeric|min:0|max:100',
        ]);

        session(['form_data.progres_pembayaran' => $validated['progres_pembayaran']]);

        return redirect()->route('dashboard')->with('success', 'Progres pembayaran berhasil diupdate.');
    }
}
