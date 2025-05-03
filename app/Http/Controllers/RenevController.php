<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RenevController extends Controller
{
    public function index()
    {
        return view('halrenev');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unsur' => 'required|string',
            'fungsi' => 'required|string',
            'no_prk' => 'required|string',
            'no_skko' => 'required|string',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        $formData = $request->all();

        // Tambahkan awalan untuk PRK dan SKKO
        $formData['no_prk'] = 'PRK.3216.' . $formData['no_prk'];
        $formData['no_skko'] = 'SKKO.3216.' . $formData['no_skko'];

        // Simpan di session
        session(['form_data' => $formData]);

        return redirect()->route('halrenev.hasil')->with('success', 'Data berhasil disimpan.');
    }

    public function hasil()
    {
        $data = session('form_data');
        return view('hasil', compact('data'));
    }
}
