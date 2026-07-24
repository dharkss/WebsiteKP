<x-layouts::app :title="__('Data Peleburan')">
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Data Catatan Harian</h1>
            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium">
                + Tambah Data
            </a>
        </div>

        <!-- Filter -->
        <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow border border-zinc-200 dark:border-zinc-700">
            <form method="GET" action="{{ route('data-peleburan.index') }}" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Kontrak Karya</label>
                    <select name="kontrak_karya" class="mt-1 block rounded-md border-gray-300 shadow-sm dark:bg-zinc-900 dark:border-gray-700 dark:text-white">
                        <option value="">-- Semua --</option>
                        @foreach($kontrakOptions ?? [] as $opt)
                            <option value="{{ $opt }}" @selected(($selectedKontrak ?? '') == $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm">
                    Filter
                </button>
                @if($selectedKontrak)
                    <a href="{{ route('data-peleburan.index') }}" class="text-sm text-zinc-500 underline">Reset</a>
                @endif
            </form>
        </div>

        <!-- Tabel -->
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow border border-zinc-200 dark:border-zinc-700 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-700 text-zinc-500 text-sm">
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">No. Lebur</th>
                        <th class="p-3">Kontrak Karya</th>
                        <th class="p-3">Jenis Material</th>
                        <th class="p-3">Berat Material</th>
                        <th class="p-3">Berat Logam</th>
                        <th class="p-3">Berat Slag</th>
                        <th class="p-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50 text-zinc-900 dark:text-zinc-100 text-sm">
                            <td class="p-3">{{ $row->tanggal_lebur }}</td>
                            <td class="p-3">{{ $row->no_lebur }}</td>
                            <td class="p-3">{{ $row->kontrak_karya }}</td>
                            <td class="p-3">{{ $row->jenis_material }}</td>
                            <td class="p-3">{{ number_format($row->berat_material ?? 0, 2) }}</td>
                            <td class="p-3">{{ number_format($row->berat_logam ?? 0, 2) }}</td>
                            <td class="p-3">{{ number_format($row->berat_slag ?? 0, 2) }}</td>
                            <td class="p-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('data-peleburan.edit', $row->id) }}"
                                       class="px-3 py-1.5 rounded-md bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('data-peleburan.destroy', $row->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-zinc-500 text-sm">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $data->links() }}
        </div>
    </div>
</x-layouts::app>