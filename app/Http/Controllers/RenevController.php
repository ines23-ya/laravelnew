<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RenevExport;
use App\Models\Renev;
use App\Models\Fungsi;
use App\Models\Unsur;

class RenevController extends Controller
{
    public function index()
    {
        // Fetch all Renev data with relations (Unsur and Fungsi)
        $renevs = Renev::with(['unsur', 'fungsi'])->get();
        $unsurs = Unsur::all(); // For dropdown
        $fungsis = Fungsi::all(); // For dropdown

        return view('halrenev', compact('renevs', 'unsurs', 'fungsis'));
    }

    /**
     * Store newly created Renev data to the database
     */
    public function store(Request $request)
    {
        $request->validate([
            'unsur_id' => 'required|exists:unsurs,id',
            'no_skko' => 'required|string|max:50',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        // Save the data to the database
        $renev = Renev::create([
            'unsur_id' => $request->unsur_id,
            'fungsi_id' => $request->fungsi_id,
            'no_prk' => 'PRK.3216.' . $request->no_prk,
            'no_skko' => 'SKKO.3216.' . $request->no_skko,
            'pekerjaan' => $request->pekerjaan,
            'satuan' => $request->satuan,
            'volume' => $request->volume,
            'total_material' => $request->total_material,
            'total_jasa' => $request->total_jasa,
            'jumlah_pagu' => $request->jumlah_pagu,
        ]);

        // Store the newly created data in the session for export
        session(['data' => $renev]);  // Store the saved data for export

        // Redirect to the Renev page and send the newly saved data
        return redirect()->route('halrenev')
            ->with('success', 'Data successfully saved.')
            ->with('data', $renev);  // Send the newly saved data to the page
    }

  
    public function reports() // index
    {
        $renevs = Renev::with(['unsur', 'fungsi'])->get();
        $unsurs = Unsur::all();
        $fungsis = Fungsi::all();
        return view('reports.index', compact('renevs', 'unsurs', 'fungsis'));
    }

    public function reportsEdit($id) // edit
    {
        $renev = Renev::findOrFail($id);
        $unsurs = Unsur::all();
        $fungsis = Fungsi::all();
        return view('reports.edit', compact('renev', 'unsurs', 'fungsis'));
    }

    public function reportsUpdate(Request $request, $id) // update
    {
        $request->validate([
            'unsur_id' => 'required|exists:unsurs,id',
            'fungsi_id' => 'required|exists:fungsis,id',
            'no_prk' => 'required|string|max:50',
            'no_skko' => 'required|string|max:50',
            'pekerjaan' => 'required|string',
            'satuan' => 'required|string',
            'volume' => 'required|numeric',
            'total_material' => 'required|numeric',
            'total_jasa' => 'required|numeric',
            'jumlah_pagu' => 'required|numeric',
        ]);

        $renev = Renev::findOrFail($id);
        $renev->update([
            'unsur_id' => $request->unsur_id,
            'fungsi_id' => $request->fungsi_id,
            'no_prk' => 'PRK.3216.' . $request->no_prk,
            'no_skko' => 'SKKO.3216.' . $request->no_skko,
            'pekerjaan' => $request->pekerjaan,
            'satuan' => $request->satuan,
            'volume' => $request->volume,
            'total_material' => $request->total_material,
            'total_jasa' => $request->total_jasa,
            'jumlah_pagu' => $request->jumlah_pagu,
        ]);

        return redirect()->route('reports.index')->with('success', 'Data berhasil diupdate!');
    }

    //hapus report
    public function reportsDestroy($id)
    {
        $renev = Renev::findOrFail($id);
        $renev->delete();

        return redirect()->route('reports.index')->with('success', 'Data berhasil dihapus.');
    }

}
