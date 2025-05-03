<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KontrakController extends Controller
{
    // Tampilkan form input
    public function create()
    {
        return view('inputkontrak');
    }

    // Simpan ke session
    public function store(Request $request)
    {
        $request->validate([
            'pekerjaan' => 'required|string|max:255',
            'nilai' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        $dataLama = session('data_kontrak', []);

        $dataBaru = [
            'pekerjaan' => $request->pekerjaan,
            'nilai' => $request->nilai,
            'tanggal' => $request->tanggal,
        ];

        session(['data_kontrak' => [...$dataLama, $dataBaru]]);

        return redirect()->route('kontrak.index')->with('success', 'Data berhasil disimpan.');
    }

    // Tampilkan semua data kontrak dari session
    public function index()
    {
        $kontraks = session('data_kontrak', []);
        return view('hasilkontrak', compact('kontraks'));
    }
}
