<x-layouts::app :title="__('Edit Data Peleburan')">
    <div class="p-6 max-w-5xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <div class="flex items-center justify-between mb-6 border-b pb-2">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Catatan Harian Peleburan</h2>
                <a href="{{ route('data-peleburan.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('data-peleburan.update', $catatan->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lebur</label>
                    <input type="date" name="tanggal_lebur" value="{{ old('tanggal_lebur', $catatan->tanggal_lebur) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">No. Lebur</label>
                    <input type="number" name="no_lebur" value="{{ old('no_lebur', $catatan->no_lebur) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontrak Karya</label>
                    <input type="text" name="kontrak_karya" list="kontrakKaryaList" value="{{ old('kontrak_karya', $catatan->kontrak_karya) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="kontrakKaryaList">
                        @foreach($kontrakOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanur Pemakaian</label>
                    <input type="text" name="tanur_pemakaian" list="tanurPemakaianList" value="{{ old('tanur_pemakaian', $catatan->tanur_pemakaian) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="tanurPemakaianList">
                        @foreach($tanurOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Krusibel Ke-</label>
                    <input type="number" name="krusibel_ke" value="{{ old('krusibel_ke', $catatan->krusibel_ke) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Material</label>
                    <input type="text" name="jenis_material" list="jenisMaterialList" value="{{ old('jenis_material', $catatan->jenis_material) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="jenisMaterialList">
                        @foreach($materialOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Material (Kg)</label>
                    <input type="number" step="0.01" name="berat_material" value="{{ old('berat_material', $catatan->berat_material) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Ingot</label>
                    <input type="number" name="jumlah_ingot" value="{{ old('jumlah_ingot', $catatan->jumlah_ingot) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Fluks</label>
                    <input type="text" name="jenis_fluks" list="jenisFluksList" value="{{ old('jenis_fluks', $catatan->jenis_fluks) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="jenisFluksList">
                        @foreach($fluksOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Fluks (Kg)</label>
                    <input type="number" step="0.01" name="berat_fluks" value="{{ old('berat_fluks', $catatan->berat_fluks) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                @php
                    // Helper lokal: potong value waktu jadi H:i saja, aman
                    // walaupun tersimpan dengan detik (H:i:s) di database.
                    $formatJam = fn ($value) => $value ? substr($value, 0, 5) : null;
                @endphp

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Loading Dore</label>
                    <input type="time" name="loading_dore" value="{{ old('loading_dore', $formatJam($catatan->loading_dore)) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pouring</label>
                    <input type="time" name="pouring" value="{{ old('pouring', $formatJam($catatan->pouring)) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Jam Alat</label>
                    <input type="time" name="jumlah_jam_alat" value="{{ old('jumlah_jam_alat', $formatJam($catatan->jumlah_jam_alat)) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Completed SOF</label>
                    <input type="time" name="completed_sof" value="{{ old('completed_sof', $formatJam($catatan->completed_sof)) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suhu ( &deg;C )</label>
                    <input type="number" name="suhu" value="{{ old('suhu', $catatan->suhu) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Logam (Kg)</label>
                    <input type="number" step="0.01" name="berat_logam" value="{{ old('berat_logam', $catatan->berat_logam) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Anoda/Bar/Ball</label>
                    <input type="number" name="jumlah_anoda_bar_ball" value="{{ old('jumlah_anoda_bar_ball', $catatan->jumlah_anoda_bar_ball) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Sample (Kg)</label>
                    <input type="number" step="0.01" name="berat_sampel" value="{{ old('berat_sampel', $catatan->berat_sampel) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Slag (Kg)</label>
                    <input type="number" step="0.01" name="berat_slag" value="{{ old('berat_slag', $catatan->berat_slag) }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div class="md:col-span-2 mt-6 flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow-md transition duration-200">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('data-peleburan.index') }}"
                       class="flex-1 text-center bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-800 dark:text-white font-bold py-3 px-4 rounded-md shadow-md transition duration-200">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>