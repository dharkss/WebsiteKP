<?php

namespace App\Http\Controllers;

use App\Models\Chg;
use App\Models\Clg;
use App\Models\MineralDressingFeed;
use Illuminate\Http\Request;

class MineralDressingController extends Controller
{
    public function createInputFeed()
    {
        return view('mineral-dressing.input-feed');
    }

    public function storeInputFeed(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'total_feed' => 'required|numeric',
        ]);

        MineralDressingFeed::create($validated);

        return redirect()->back()->with('success', 'Data Mineral Dressing berhasil disimpan!');
    }

    public function createChg()
    {
        return view('mineral-dressing.chg');
    }

    public function storeChg(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kode_material' => 'required|string',
            'berat_chg' => 'required|numeric',
            'berat_balldore' => 'required|numeric',
        ]);

        Chg::create($validated);

        return redirect()->back()->with('success', 'Data CHG berhasil disimpan!');
    }

    public function createClg()
    {
        return view('mineral-dressing.clg');
    }

    public function storeClg(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pengeluaran' => 'required|date',
            'kode_material' => 'required|string',
            'berat_clg' => 'required|numeric',
            'moisture_content' => 'required|numeric',
            'berat_kering' => 'required|numeric',
            'kadar_au' => 'required|numeric',
            'kadar_ag' => 'required|numeric',
            'kadar_au_reproses' => 'nullable|numeric',
            'kadar_ag_reproses' => 'nullable|numeric',
        ]);

        Clg::create($validated);

        return redirect()->back()->with('success', 'Data CLG berhasil disimpan!');
    }
}