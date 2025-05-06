<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KontrakExport;
use Barryvdh\DomPDF\Facade\Pdf;

class KontruksiController extends Controller
{
    public function index(Request $request)
    {
        $no_kontrak = $request->query('no_kontrak');
        $data_pbj = session('data_pbj', []);

        return view('halkontruksi', compact('data_pbj', 'no_kontrak'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pekerjaan' => 'required|string',
            'nomor_kontrak' => 'required|string',
            'progres' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
            'bp_lkp' => 'required|file|mimes:pdf',
            'bp_st' => 'required|file|mimes:pdf',
            'bp_pp' => 'required|file|mimes:pdf',
        ]);

        $no_kontrak = trim(strtolower($validated['nomor_kontrak']));

        $pbjData = collect(session('data_pbj', []))->first(function ($pbj) use ($no_kontrak) {
            return isset($pbj['no_kontrak']) && trim(strtolower($pbj['no_kontrak'])) === $no_kontrak;
        });

        $newData = [
            'pekerjaan'        => $validated['pekerjaan'],
            'no_kontrak'       => $validated['nomor_kontrak'],
            'tanggal_kontrak'  => $pbjData['tanggal_kontrak'] ?? null,
            'nilai'            => $pbjData['nilai_kontrak'] ?? 0,
            'progres'          => $validated['progres'],
            'keterangan'       => $validated['keterangan'] ?? '',
            'bp_lkp'           => $request->file('bp_lkp')->store('pdf', 'public'),
            'bp_st'            => $request->file('bp_st')->store('pdf', 'public'),
            'bp_pp'            => $request->file('bp_pp')->store('pdf', 'public'),
        ];

        $data_kontrak = session('data_kontrak', []);
        $updated = false;

        foreach ($data_kontrak as &$item) {
            if (trim(strtolower($item['no_kontrak'] ?? '')) === $no_kontrak) {
                $item = array_merge($item, $newData);
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $data_kontrak[] = $newData;
        }

        session(['data_kontrak' => $data_kontrak]);

        return redirect()->route('hasilkontrak')->with('success', 'Data berhasil disimpan!');
    }

    public function hasil()
    {
        $kontrak = session('data_kontrak', []);
        return view('hasilkontrak', compact('kontrak'));
    }

    public function pilih(Request $request)
    {
        $no_kontrak = $request->query('no_kontrak');
        return view('inputkontrak', compact('no_kontrak'));
    }

    // EXPORT TO EXCEL
    public function exportExcel()
    {
        $data = session('data_kontrak', []);
        return Excel::download(new KontrakExport(collect($data)), 'data_kontrak.xlsx');
    }

    // EXPORT TO PDF
    public function exportPDF()
    {
        $data = session('data_kontrak', []);
        $pdf = Pdf::loadView('exports.kontrak_pdf', ['kontrak' => $data]);
        return $pdf->download('data_kontrak.pdf');
    }
}
