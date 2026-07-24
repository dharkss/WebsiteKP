<?php

namespace App\Http\Controllers;

use App\Models\CatatanHarian;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Illuminate\Http\Request;

class CatatanHarianController extends Controller
{
    /**
     * Helper: ambil opsi datalist (nilai unik yang sudah pernah diinput)
     * untuk field Kontrak Karya, Tanur Pemakaian, Jenis Material, Jenis Fluks.
     * Setiap kali user mengetik nilai baru dan menyimpan, nilai itu otomatis
     * akan muncul di datalist ini pada pemanggilan berikutnya.
     */
    private function getDatalistOptions()
    {
        return [
            'kontrakOptions' => CatatanHarian::select('kontrak_karya')
                ->distinct()->whereNotNull('kontrak_karya')->pluck('kontrak_karya'),
            'tanurOptions' => CatatanHarian::select('tanur_pemakaian')
                ->distinct()->whereNotNull('tanur_pemakaian')->pluck('tanur_pemakaian'),
            'materialOptions' => CatatanHarian::select('jenis_material')
                ->distinct()->whereNotNull('jenis_material')->pluck('jenis_material'),
            'fluksOptions' => CatatanHarian::select('jenis_fluks')
                ->distinct()->whereNotNull('jenis_fluks')->pluck('jenis_fluks'),
        ];
    }

    /**
     * Helper: normalisasi field waktu (H:i) sebelum divalidasi.
     * 1. Kalau browser mengirim string kosong "" (bukan null) karena field
     *    time tidak disentuh user, ubah jadi null supaya rule "nullable"
     *    benar-benar berlaku dan tidak lolos ke pengecekan date_format:H:i.
     * 2. Kalau value terkirim dengan detik (mis. "22:01:00" karena value asal
     *    di database/HTML bertipe H:i:s), potong jadi "H:i" saja supaya lolos
     *    validasi date_format:H:i.
     */
    private function normalizeWaktu(Request $request)
    {
        $fields = ['loading_dore', 'pouring', 'jumlah_jam_alat', 'completed_sof'];

        $normalized = [];
        foreach ($fields as $field) {
            $value = $request->input($field);

            if (! $value) {
                $normalized[$field] = null;

                continue;
            }

            // Ambil hanya bagian HH:MM di depan, buang detik jika ada.
            if (preg_match('/^(\d{1,2}:\d{2})/', trim($value), $matches)) {
                $normalized[$field] = $matches[1];
            } else {
                $normalized[$field] = $value;
            }
        }

        $request->merge($normalized);
    }

    /**
     * Tampilkan formulir catatan harian.
     */
    public function create()
    {
        return view('dashboard', $this->getDatalistOptions());
    }

    public function store(Request $request)
    {
        // 0. Normalisasi field waktu (string kosong -> null)
        $this->normalizeWaktu($request);

        // 1. Validasi Input
        $validated = $request->validate([
            'tanggal_lebur' => 'required|date',
            'no_lebur' => 'required|integer',
            'kontrak_karya' => 'required|string',
            'tanur_pemakaian' => 'required|string',
            'krusibel_ke' => 'required|integer',
            'jenis_material' => 'required|string',
            'berat_material' => 'required|numeric',
            'jumlah_ingot' => 'nullable|integer',
            'jenis_fluks' => 'required|string',
            'berat_fluks' => 'required|numeric',
            'loading_dore' => 'nullable|date_format:H:i',
            'pouring' => 'nullable|date_format:H:i',
            'jumlah_jam_alat' => 'nullable|date_format:H:i',
            'completed_sof' => 'nullable|date_format:H:i',
            'suhu' => 'nullable|integer',
            'berat_logam' => 'required|numeric',
            'jumlah_anoda_bar_ball' => 'nullable|integer',
            'berat_sampel' => 'required|numeric',
            'berat_slag' => 'required|numeric',
        ]);

        // 2. Simpan ke database bawaan (SQLite)
        CatatanHarian::create($validated);

        // 3. Tembak data langsung ke Google Sheets
        try {
            $client = new Client;
            $client->setAuthConfig(storage_path('app/google-credentials.json'));
            $client->addScope(Sheets::SPREADSHEETS);

            $service = new Sheets($client);

            $spreadsheetId = '1d95pJnZzLJiPYuMhfio8h05lmvLnklbKR1JJKmbJoew';
            $range = 'Sheet1!A:S';

            $values = [
                array_values([
                    $request->tanggal_lebur ?? '',
                    $request->no_lebur ?? '',
                    $request->kontrak_karya ?? '',
                    $request->tanur_pemakaian ?? '',
                    $request->krusibel_ke ?? '',
                    $request->jenis_material ?? '',
                    $request->berat_material ?? '',
                    $request->jumlah_ingot ?? '',
                    $request->jenis_fluks ?? '',
                    $request->berat_fluks ?? '',
                    $request->loading_dore ?? '',
                    $request->pouring ?? '',
                    $request->jumlah_jam_alat ?? '',
                    $request->completed_sof ?? '',
                    $request->suhu ?? '',
                    $request->berat_logam ?? '',
                    $request->jumlah_anoda_bar_ball ?? '',
                    $request->berat_sampel ?? '',
                    $request->berat_slag ?? '',
                ]),
            ];

            $body = new ValueRange([
                'values' => $values,
            ]);

            $params = [
                'valueInputOption' => 'USER_ENTERED',
            ];

            $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data masuk ke sistem lokal, tapi gagal sinkronisasi ke Sheets: '.$e->getMessage());
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
            $query->whereBetween('tanggal_lebur', [$request->start_date, $request->end_date]);
        }

        $totalMaterial = (clone $query)->sum('berat_material');
        $totalLogam = (clone $query)->sum('berat_logam');
        $totalSlag = (clone $query)->sum('berat_slag');

        $persentaseLoss = $totalMaterial > 0
            ? (($totalMaterial - $totalLogam - $totalSlag) / $totalMaterial) * 100
            : 0;

        $byKontrak = (clone $query)
            ->selectRaw('kontrak_karya, SUM(berat_material) as total_material, SUM(berat_logam) as total_logam, SUM(berat_slag) as total_slag')
            ->groupBy('kontrak_karya')
            ->get();

        $byDate = (clone $query)
            ->selectRaw('tanggal_lebur as tanggal, SUM(berat_material) as total_material, SUM(berat_logam) as total_logam, SUM(berat_fluks) as total_fluks, SUM(berat_slag) as total_slag')
            ->groupBy('tanggal_lebur')
            ->orderBy('tanggal_lebur')
            ->get();

        // Recovery (%) per tanggal, dipakai di chart combo dashboard-peleburan
        $byDate->transform(function ($row) {
            $row->recovery = $row->total_material > 0
                ? ($row->total_logam / $row->total_material) * 100
                : 0;

            return $row;
        });

        $kontrakOptions = CatatanHarian::select('kontrak_karya')
            ->distinct()
            ->whereNotNull('kontrak_karya')
            ->pluck('kontrak_karya');

        return view('dashboard-peleburan', [
            'totalMaterial' => $totalMaterial,
            'totalAnoda' => $totalLogam,
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

    /**
     * BARU: Tampilkan daftar semua catatan harian (bisa difilter per kontrak karya).
     */
    public function index(Request $request)
    {
        $query = CatatanHarian::query();

        if ($request->filled('kontrak_karya')) {
            $query->where('kontrak_karya', $request->kontrak_karya);
        }

        $data = $query
            ->orderByDesc('tanggal_lebur')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $kontrakOptions = CatatanHarian::select('kontrak_karya')
            ->distinct()->whereNotNull('kontrak_karya')->pluck('kontrak_karya');

        return view('data-peleburan', [
            'data' => $data,
            'kontrakOptions' => $kontrakOptions,
            'selectedKontrak' => $request->kontrak_karya,
        ]);
    }

    /**
     * BARU: Tampilkan form edit untuk satu baris data.
     */
    public function edit(CatatanHarian $catatanHarian)
    {
        return view('data-peleburan-edit', array_merge(
            ['catatan' => $catatanHarian],
            $this->getDatalistOptions()
        ));
    }

    /**
     * BARU: Update satu baris data.
     */
    public function update(Request $request, CatatanHarian $catatanHarian)
    {
        // 0. Normalisasi field waktu (string kosong -> null)
        $this->normalizeWaktu($request);

        $validated = $request->validate([
            'tanggal_lebur' => 'required|date',
            'no_lebur' => 'required|integer',
            'kontrak_karya' => 'required|string',
            'tanur_pemakaian' => 'required|string',
            'krusibel_ke' => 'required|integer',
            'jenis_material' => 'required|string',
            'berat_material' => 'required|numeric',
            'jumlah_ingot' => 'nullable|integer',
            'jenis_fluks' => 'required|string',
            'berat_fluks' => 'required|numeric',
            'loading_dore' => 'nullable|date_format:H:i',
            'pouring' => 'nullable|date_format:H:i',
            'jumlah_jam_alat' => 'nullable|date_format:H:i',
            'completed_sof' => 'nullable|date_format:H:i',
            'suhu' => 'nullable|integer',
            'berat_logam' => 'required|numeric',
            'jumlah_anoda_bar_ball' => 'nullable|integer',
            'berat_sampel' => 'required|numeric',
            'berat_slag' => 'required|numeric',
        ]);

        $catatanHarian->update($validated);

        return redirect()
            ->route('data-peleburan.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * BARU: Hapus satu baris data.
     */
    public function destroy(CatatanHarian $catatanHarian)
    {
        $catatanHarian->delete();

        return redirect()
            ->route('data-peleburan.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}