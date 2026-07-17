<x-layouts::app :title="__('Dashboard Peleburan')">
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        <!-- Tabs (opsional, sambungkan ke route modul lain jika ada) -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('laporan-peleburan.dashboard') }}"
               class="px-6 py-3 rounded-lg font-semibold text-white bg-teal-600 hover:bg-teal-700 transition">
                Peleburan
            </a>
            {{-- Tambahkan tab lain di sini jika sudah ada route/modul-nya, contoh: --}}
            {{-- <a href="#" class="px-6 py-3 rounded-lg font-semibold text-white bg-teal-600/70 hover:bg-teal-700 transition">Material Internal</a> --}}
            {{-- <a href="#" class="px-6 py-3 rounded-lg font-semibold text-white bg-teal-600/70 hover:bg-teal-700 transition">Mineral Dressing</a> --}}
        </div>

        <!-- Filter -->
        <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow border border-zinc-200 dark:border-zinc-700">
            <form method="GET" action="{{ route('laporan-peleburan.dashboard') }}" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Kontrak Karya</label>
                    <select name="kontrak_karya" class="mt-1 block rounded-md border-gray-300 shadow-sm dark:bg-zinc-900 dark:border-gray-700 dark:text-white">
                        <option value="">-- Semua --</option>
                        @foreach($kontrakOptions ?? [] as $opt)
                            <option value="{{ $opt }}" @selected(($selectedKontrak ?? '') == $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="mt-1 block rounded-md border-gray-300 shadow-sm dark:bg-zinc-900 dark:border-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="mt-1 block rounded-md border-gray-300 shadow-sm dark:bg-zinc-900 dark:border-gray-700 dark:text-white">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm">
                    Filter
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 bg-amber-50 dark:bg-zinc-800 rounded-xl shadow border border-amber-300 dark:border-zinc-700 text-center">
                <p class="text-sm text-zinc-500">Berat Material (kg)</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($totalMaterial ?? 0, 2) }}</p>
            </div>

            <div class="p-4 bg-amber-50 dark:bg-zinc-800 rounded-xl shadow border border-amber-300 dark:border-zinc-700 text-center">
                <p class="text-sm text-zinc-500">Berat Anoda (kg)</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($totalAnoda ?? 0, 2) }}</p>
            </div>

            <div class="p-4 bg-amber-50 dark:bg-zinc-800 rounded-xl shadow border border-amber-300 dark:border-zinc-700 text-center">
                <p class="text-sm text-zinc-500">Berat Slag (kg)</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($totalSlag ?? 0, 2) }}</p>
            </div>

            <div class="p-4 bg-amber-50 dark:bg-zinc-800 rounded-xl shadow border border-amber-300 dark:border-zinc-700 text-center">
                <p class="text-sm text-zinc-500">Persentase Loss</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($persentaseLoss ?? 0, 2) }}%</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- Bar chart per Kontrak Karya -->
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl shadow border border-zinc-200 dark:border-zinc-700">
                <h2 class="text-sm font-medium mb-4 text-zinc-700 dark:text-zinc-300">
                    Pembagian Berat Material, Anoda, dan Slag (kg) berdasarkan Kontrak Karya
                </h2>
                <div class="relative" style="height: 360px;">
                    <canvas id="chartByKontrak"></canvas>
                </div>
            </div>

            <!-- Combo chart per Tanggal -->
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl shadow border border-zinc-200 dark:border-zinc-700">
                <h2 class="text-sm font-medium mb-4 text-zinc-700 dark:text-zinc-300">
                    Pembagian Berat Material, Fluks, dan Slag (kg) berdasarkan Tanggal
                </h2>
                <div class="relative" style="height: 360px;">
                    <canvas id="chartByDate"></canvas>
                </div>
            </div>

        </div>

        <!-- Data Presentation (Tabel detail) -->
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl shadow border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold mb-4 text-zinc-900 dark:text-white">Catatan Per Tanggal</h2>
            @if(isset($byDate) && count($byDate) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700 text-zinc-500 text-sm">
                                <th class="pb-2">Tanggal</th>
                                <th class="pb-2">Material</th>
                                <th class="pb-2">Anoda</th>
                                <th class="pb-2">Fluks</th>
                                <th class="pb-2">Slag</th>
                                <th class="pb-2">Recovery</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byDate as $row)
                                <tr class="border-b border-zinc-100 dark:border-zinc-700/50 text-zinc-900 dark:text-zinc-100 text-sm">
                                    <td class="py-2">{{ $row->tanggal }}</td>
                                    <td class="py-2">{{ number_format($row->total_material ?? 0, 2) }}</td>
                                    <td class="py-2">{{ number_format($row->total_anoda ?? 0, 2) }}</td>
                                    <td class="py-2">{{ number_format($row->total_fluks ?? 0, 2) }}</td>
                                    <td class="py-2">{{ number_format($row->total_slag ?? 0, 2) }}</td>
                                    <td class="py-2">{{ number_format($row->recovery ?? 0, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-zinc-500 text-sm">Belum ada data pencatatan peleburan.</p>
            @endif
        </div>

        <!-- By Kontrak Karya -->
        <div class="bg-white dark:bg-zinc-800 p-6 rounded-xl shadow border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold mb-4 text-zinc-900 dark:text-white">Catatan Per Kontrak Karya</h2>
            @if(isset($byKontrak) && count($byKontrak) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700 text-zinc-500 text-sm">
                                <th class="pb-2">Kontrak Karya</th>
                                <th class="pb-2">Total Material</th>
                                <th class="pb-2">Total Anoda</th>
                                <th class="pb-2">Total Slag</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byKontrak as $row)
                                <tr class="border-b border-zinc-100 dark:border-zinc-700/50 text-zinc-900 dark:text-zinc-100 text-sm">
                                    <td class="py-2">{{ $row->kontrak_karya ?? '-' }}</td>
                                    <td class="py-2">{{ number_format($row->total_material ?? 0, 2) }}</td>
                                    <td class="py-2">{{ number_format($row->total_anoda ?? 0, 2) }}</td>
                                    <td class="py-2">{{ number_format($row->total_slag ?? 0, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-zinc-500 text-sm">Belum ada data.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ----- Data dari Blade -----
            const byKontrak = @json($byKontrak ?? []);
            const byDate = @json($byDate ?? []);

            const kontrakLabels = byKontrak.map(r => r.kontrak_karya ?? '-');
            const kontrakMaterial = byKontrak.map(r => parseFloat(r.total_material ?? 0));
            const kontrakAnoda = byKontrak.map(r => parseFloat(r.total_anoda ?? 0));
            const kontrakSlag = byKontrak.map(r => parseFloat(r.total_slag ?? 0));

            const dateLabels = byDate.map(r => r.tanggal);
            const dateMaterial = byDate.map(r => parseFloat(r.total_material ?? 0));
            const dateFluks = byDate.map(r => parseFloat(r.total_fluks ?? 0));
            const dateSlag = byDate.map(r => parseFloat(r.total_slag ?? 0));
            const dateRecovery = byDate.map(r => parseFloat(r.recovery ?? 0));

            // ----- Chart 1: Bar chart per Kontrak Karya -----
            new Chart(document.getElementById('chartByKontrak'), {
                type: 'bar',
                data: {
                    labels: kontrakLabels,
                    datasets: [
                        {
                            label: 'Berat Material (kg)',
                            data: kontrakMaterial,
                            backgroundColor: '#2f8f86'
                        },
                        {
                            label: 'Berat Anoda (kg)',
                            data: kontrakAnoda,
                            backgroundColor: '#c9c9c9'
                        },
                        {
                            label: 'Berat Slag (kg)',
                            data: kontrakSlag,
                            backgroundColor: '#e0433a'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // ----- Chart 2: Combo chart per Tanggal (bar + line Recovery) -----
            new Chart(document.getElementById('chartByDate'), {
                data: {
                    labels: dateLabels,
                    datasets: [
                        {
                            type: 'line',
                            label: 'Recovery',
                            data: dateRecovery,
                            borderColor: '#2f8f86',
                            backgroundColor: '#2f8f86',
                            yAxisID: 'y1',
                            tension: 0.3,
                            pointRadius: 2
                        },
                        {
                            type: 'bar',
                            label: 'Berat Material (kg)',
                            data: dateMaterial,
                            backgroundColor: '#c9c9c9',
                            yAxisID: 'y'
                        },
                        {
                            type: 'bar',
                            label: 'Berat Fluks (kg)',
                            data: dateFluks,
                            backgroundColor: '#e0433a',
                            yAxisID: 'y'
                        },
                        {
                            type: 'bar',
                            label: 'Berat Slag (kg)',
                            data: dateSlag,
                            backgroundColor: '#f2a11e',
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            position: 'left',
                            beginAtZero: true,
                            title: { display: true, text: 'Berat (kg)' }
                        },
                        y1: {
                            type: 'linear',
                            position: 'right',
                            beginAtZero: true,
                            max: 100,
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Recovery (%)' }
                        }
                    }
                }
            });
        });
    </script>
</x-layouts::app>