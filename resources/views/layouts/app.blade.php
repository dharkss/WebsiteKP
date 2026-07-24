<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white dark:bg-zinc-900 data-[sidebar]:bg-zinc-50 data-[sidebar]:dark:bg-zinc-950 antialiased">

    <!-- Sidebar Utama -->
    <flux:sidebar sticky collapsible class="border-r border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950">
        <flux:sidebar.toggle class="lg:hidden" />

        <div class="flex items-center gap-2 px-6 py-4">
            <span class="font-semibold text-zinc-900 dark:text-white">Smelting</span>
        </div>

        <flux:navlist vertical>
            <flux:navlist.item href="{{ route('dashboard') }}" icon="home">
                Form Catatan Peleburan
            </flux:navlist.item>

            <flux:navlist.item href="{{ route('data-peleburan.index') }}" icon="table-cells">
                Data Peleburan
            </flux:navlist.item>

            <flux:navlist.group heading="Report Laporan (SOF) Kontrak Karya" icon="document-chart-bar" expandable>
                <flux:navlist.item href="{{ route('laporan-peleburan.dashboard', ['kontrak_karya' => 'PT. BSI']) }}">
                    PT. BSI
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.item href="{{ route('laporan-peleburan.dashboard') }}" icon="chart-bar">
                Dashboard Peleburan
            </flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <!-- Menu User di Bagian Bawah -->
        <div class="mt-auto p-4 border-t border-zinc-200 dark:border-zinc-800">
            {{-- Sesuaikan dengan sistem auth kamu, atau hapus kalau belum ada --}}
            @auth
            <flux:dropdown position="top" align="start">
                <flux:profile
                    name="{{ auth()->user()->name }}"
                    icon-trailing="chevrons-up-down"
                />
                <flux:menu>
                    <flux:menu.item onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </flux:menu.item>
                </flux:menu>
            </flux:dropdown>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
            @endauth
        </div>
    </flux:sidebar>

    <!-- Konten Utama -->
    <flux:main>
        {{ $slot }}
    </flux:main>

    @fluxScripts
</body>
</html>