<x-layouts::app :title="__('Input Data CHG')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-2">
                Input Data CHG (Concentrate High Grade)
            </h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('mineral-dressing.chg.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                    <input type="date" name="tanggal" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Material</label>
                    <input type="text" name="kode_material" required placeholder="Contoh: CHG-001"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat CHG (Kg)</label>
                    <input type="number" step="0.01" name="berat_chg" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Balldore Dihasilkan (Kg)</label>
                    <input type="number" step="0.01" name="berat_balldore" required placeholder="0.00"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div class="md:col-span-2 mt-6">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow-md transition duration-200">
                        Simpan Data CHG
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>