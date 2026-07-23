<x-layouts::app :title="__('Laporan Peleburan')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-2">
                Formulir Catatan Harian Peleburan
            </h2>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded shadow">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded shadow">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('catatan-harian.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- Tanggal Lebur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lebur</label>
                    <input type="date" name="tanggal_lebur" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- No. Lebur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">No. Lebur</label>
                    <input type="number" step="1" name="no_lebur" required placeholder="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Kontrak Karya (string + datalist, bisa nambah sendiri) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontrak Karya</label>
                    <input type="text" name="kontrak_karya" list="kontrakKaryaList" required
                           placeholder="Ketik atau pilih..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="kontrakKaryaList">
                        @foreach($kontrakOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Tanur Pemakaian (string + datalist) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanur Pemakaian</label>
                    <input type="text" name="tanur_pemakaian" list="tanurPemakaianList" required
                           placeholder="Ketik atau pilih..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="tanurPemakaianList">
                        @foreach($tanurOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Krusibel Ke- -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Krusibel Ke-</label>
                    <input type="number" step="1" name="krusibel_ke" required placeholder="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Jenis Material (string + datalist) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Material</label>
                    <input type="text" name="jenis_material" list="jenisMaterialList" required
                           placeholder="Contoh: Bijih Tembaga"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="jenisMaterialList">
                        @foreach($materialOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Berat Material (Kg) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Material (Kg)</label>
                    <input type="number" step="0.01" name="berat_material" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Jumlah Ingot -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Ingot</label>
                    <input type="number" step="1" name="jumlah_ingot" placeholder="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Jenis Fluks (string + datalist) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Fluks</label>
                    <input type="text" name="jenis_fluks" list="jenisFluksList" required
                           placeholder="Contoh: Limestone / Silica"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <datalist id="jenisFluksList">
                        @foreach($fluksOptions ?? [] as $opt)
                            <option value="{{ $opt }}">
                        @endforeach
                    </datalist>
                </div>

                <!-- Berat Fluks (Kg) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Fluks (Kg)</label>
                    <input type="number" step="0.01" name="berat_fluks" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Loading Dore (jam:menit) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Loading Dore</label>
                    <input type="time" name="loading_dore"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Pouring (jam:menit) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pouring</label>
                    <input type="time" name="pouring"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Jumlah Jam Alat (jam:menit) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Jam Alat</label>
                    <input type="time" name="jumlah_jam_alat"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Completed SOF (jam:menit) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Completed SOF</label>
                    <input type="time" name="completed_sof"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Suhu -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suhu ( &deg;C )</label>
                    <input type="number" step="1" name="suhu" placeholder="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Berat Logam (Kg) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Logam (Kg)</label>
                    <input type="number" step="0.01" name="berat_logam" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Jumlah Anoda/Bar/Ball -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Anoda/Bar/Ball</label>
                    <input type="number" step="1" name="jumlah_anoda_bar_ball" placeholder="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Berat Sample (Kg) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Sample (Kg)</label>
                    <input type="number" step="0.01" name="berat_sampel" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <!-- Berat Slag (Kg) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Slag (Kg)</label>
                    <input type="number" step="0.01" name="berat_slag" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div class="md:col-span-2 mt-6">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow-md transition duration-200">
                        Simpan Data Pencatatan
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layouts::app>