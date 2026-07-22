<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white dark:bg-zinc-900 data-[sidebar]:bg-zinc-50 data-[sidebar]:dark:bg-zinc-950 antialiased">
    
    <!-- Sidebar Utama -->
    <flux:sidebar sticky collapsible class="border-r border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950">
        <!-- Judul Aplikasi / Platform -->
        <flux:sidebar.toggle class="lg:hidden" />
        
        <div class="flex items-center gap-2 px-6 py-4">
            <span class="font-semibold text-zinc-900 dark:text-white">Smelting</span>
        </div>

        <!-- Menu Navigasi Samping -->
        <flux:navlist vertical>
            <!-- Main Dashboard Link -->
            <flux:navlist.item href="{{ route('dashboard') }}" icon="home">
                Form Catatan Peleburan
            </flux:navlist.item>

            <!-- Dashboard Peleburan Link -->
            <flux:navlist.item href="{{ route('laporan-peleburan.dashboard') }}" icon="chart-bar">
                Dashboard Peleburan
            </flux:navlist.item>
        </flux:navlist>

        <flux:separator class="my-2" />

        <!-- Menu Terpisah: Report Laporan (SOF) Kontrak Karya -->
        <flux:navlist vertical>
            <flux:navlist.group heading="Report Laporan (SOF) Kontrak Karya" icon="document-chart-bar" expandable>
                <flux:navlist.item href="{{ route('laporan-peleburan.dashboard', ['kontrak_karya' => 'PT. BSI']) }}">
                    PT. BSI
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <!-- Menu User di Bagian Bawah -->
        <div class="mt-auto p-4 border-t border-zinc-200 dark:border-zinc-800">
            <x-desktop-user-menu />
        </div>
    </flux:sidebar>

    <!-- Konten Utama Dashboard -->
    <flux:main>
        {{ $slot }}
    </flux:main>

    @fluxScripts
</body>
</html>