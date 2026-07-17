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
            <x-app-logo class="size-6 text-blue-600" />
            <span class="font-semibold text-zinc-900 dark:text-white">Platform</span>
        </div>

        <!-- Menu Navigasi Samping -->
        <flux:navlist vertical>
            <!-- Main Dashboard Link -->
            <flux:navlist.item href="{{ route('dashboard') }}" icon="home">
                Dashboard
            </flux:navlist.item>

            <!-- Dashboard Peleburan Link -->
            <flux:navlist.item href="{{ route('laporan-peleburan.dashboard') }}" icon="chart-bar">
                Dashboard Peleburan
            </flux:navlist.item>
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