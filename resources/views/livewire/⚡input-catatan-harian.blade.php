<div>
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-2">
        Formulir Catatan Harian Peleburan
    </h2>
    
    <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Baris 1: Waktu & Perusahaan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Pencatatan</label>
            <input type="datetime-local" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontrak Karya</label>
            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                <option value="">-- Pilih Perusahaan --</option>
                <option value="PT Aneka Tambang Tbk">PT Aneka Tambang Tbk</option>
                <option value="PT Freeport Indonesia">PT Freeport Indonesia</option>
                <option value="PT Vale Indonesia Tbk">PT Vale Indonesia Tbk</option>
                <option value="PT Amman Mineral">PT Amman Mineral</option>
            </select>
        </div>

        <!-- Baris 2: Detail Material -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Material</label>
            <input type="text" placeholder="Contoh: Bijih Tembaga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Material</label>
            <input type="text" placeholder="Contoh: CU-001" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Material (kg)</label>
            <input type="number" step="0.01" placeholder="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Furnace</label>
            <input type="text" placeholder="Contoh: Rotary Kiln" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <!-- Baris 3: Fluks -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Fluks</label>
            <input type="text" placeholder="Contoh: Limestone / Silica" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Fluks (kg)</label>
            <input type="number" step="0.01" placeholder="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <!-- Baris 4: Hasil Akhir -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Anoda (kg)</label>
            <input type="number" step="0.01" placeholder="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Slag (kg)</label>
            <input type="number" step="0.01" placeholder="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Sampel (kg)</label>
            <input type="number" step="0.01" placeholder="0.00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <!-- Tombol Simpan -->
        <div class="md:col-span-2 mt-6">
            <button type="button" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow-md transition duration-200">
                Simpan Data Pencatatan
            </button>
        </div>
    </form>
</div>