<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanHarian;
use Google\Client;
use Google\Service\Sheets;

class CatatanHarianController extends Controller // Hanya satu '{' di sini
{   
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'waktu_pencatatan' => 'required|date',
            'kontrak_karya' => 'nullable|string',
            'jenis_material' => 'nullable|string',
            'kode_material' => 'required|string',
            'jenis_furnace' => 'nullable|string',
            'berat_material' => 'required|numeric',
            'jenis_fluks' => 'nullable|string',
            'berat_fluks' => 'required|numeric',
            'berat_anoda' => 'required|numeric',
            'berat_slag' => 'required|numeric',
            'berat_sampel' => 'required|numeric',
        ]);

        // 2. Simpan ke database bawaan (SQLite)
        CatatanHarian::create($validated);

        // 3. Tembak data langsung ke Google Sheets
        try {
            $client = new \Google\Client(); 
            $client->setAuthConfig(storage_path('app/google-credentials.json'));
            $client->addScope(\Google\Service\Sheets::SPREADSHEETS);

            $service = new \Google\Service\Sheets($client);
                    
            $spreadsheetId = '1d95pJnZzLJiPYuMhfio8h05lmvLnklbKR1JJKmbJoew'; 
            $range = 'Sheet1!A:K';

            $values = [
                array_values([
                    $request->waktu_pencatatan ?? '',
                    $request->kontrak_karya ?? '',
                    $request->jenis_material ?? '',
                    $request->kode_material ?? '',
                    $request->jenis_furnace ?? '',
                    $request->berat_material ?? '',
                    $request->jenis_fluks ?? '',
                    $request->berat_fluks ?? '',
                    $request->berat_anoda ?? '',
                    $request->berat_slag ?? '',
                    $request->berat_sampel ?? '',
                ])
            ];

            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $values
            ]);

            $params = [
                'valueInputOption' => 'USER_ENTERED'
            ];

            $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data masuk ke sistem lokal, tapi gagal sinkronisasi ke Sheets: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data peleburan berhasil disimpan dan langsung masuk ke Google Sheets!');
    }

    public function dashboard(Request $request)
    {
        $query = CatatanHarian::query();

        if ($request->filled('kontrak_karya')) {
            $query->where('kontrak_karya', $request->kontrak_karya);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('waktu_pencatatan', [$request->start_date, $request->end_date]);
        }

        $totalAnoda = (clone $query)->sum('berat_anoda');
        $totalSlag = (clone $query)->sum('berat_slag');
        $totalMaterial = (clone $query)->sum('berat_material');

        $persentaseLoss = $totalMaterial > 0
            ? (($totalMaterial - $totalAnoda - $totalSlag) / $totalMaterial) * 100
            : 0;

        // Per Kontrak Karya -> dipakai untuk bar chart perbandingan Material/Anoda/Slag
        $byKontrak = (clone $query)
            ->selectRaw('kontrak_karya, SUM(berat_material) as total_material, SUM(berat_anoda) as total_anoda, SUM(berat_slag) as total_slag')
            ->groupBy('kontrak_karya')
            ->get();

        // Per Tanggal -> dipakai untuk combo chart (bar Material/Fluks/Slag + line Recovery %)
        $byDate = (clone $query)
            ->selectRaw('DATE(waktu_pencatatan) as tanggal, SUM(berat_material) as total_material, SUM(berat_anoda) as total_anoda, SUM(berat_fluks) as total_fluks, SUM(berat_slag) as total_slag')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($row) {
                $row->recovery = $row->total_material > 0
                    ? round(($row->total_anoda / $row->total_material) * 100, 2)
                    : 0;
                return $row;
            });

        $kontrakOptions = CatatanHarian::select('kontrak_karya')
            ->distinct()
            ->whereNotNull('kontrak_karya')
            ->pluck('kontrak_karya');

        return view('dashboard-peleburan', [
            'totalMaterial' => $totalMaterial,
            'totalAnoda' => $totalAnoda,
            'totalSlag' => $totalSlag,
            'persentaseLoss' => $persentaseLoss,
            'byKontrak' => $byKontrak,
            'byDate' => $byDate,
            'kontrakOptions' => $kontrakOptions,
            'selectedKontrak' => $request->kontrak_karya,
            'startDate' => $request->start_date,
            'endDate' => $request->end_date,
        ]);
    }
}