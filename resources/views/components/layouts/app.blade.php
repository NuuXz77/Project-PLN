<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen font-sans antialiased bg-white dark:bg-base-200">
    {{-- NAVBAR mobile only --}}
    {{-- <livewire:layout.navigation /> --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            <div class="ml-5 pt-5">
                <img src="{{ asset('img/Logo_PLN.svg') }}" alt="" width="90">
            </div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">
            {{-- BRAND --}}
            <div class="ml-5 pt-5">
                <img src="{{ asset('img/Logo_PLN.svg') }}" alt="" width="100">
            </div>

            {{-- MENU --}}
            {{-- MENU --}}
            <x-mary-menu activate-by-route>
                {{-- User --}}
                @if (auth()->check())
                <x-mary-menu-separator />
                <x-mary-list-item :item="auth()->user()" value="name" no-separator no-hover
                    class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <livewire:layout.theme-toggle />
                        {{-- <x-mary-dropdown title="Settings" icon="o-cog-6-tooth">
                                <x-mary-menu-item title="Profile" icon="m-user-circle" :href="route('profile')"
                                    wire:navigate />
                                <livewire:layout.logout-button />
                            </x-mary-dropdown> --}}
                    </x-slot:actions>
                </x-mary-list-item>

                <x-mary-menu-separator />

                <x-mary-menu-item title="Dashboard" icon="o-home" link="/dashboard" />

                @if (auth()->user()->role === 'admin')
                <x-mary-menu-item title="Petugas" icon="o-users" link="/petugas" />
                <x-mary-menu-item title="Tarif" icon="o-credit-card" link="/tarif" />
                <x-mary-menu-sub title="Laporan" icon="o-magnifying-glass">
                    <x-mary-menu-item title="Pelanggan" icon="o-users" link="/laporan-pelanggan" />
                    <x-mary-menu-item title="Transaksi" icon="o-document-text" link="/laporan-transaksi" />

                </x-mary-menu-sub>
                @endif

                @if (auth()->user()->role === 'loket')
                <x-mary-menu-item title="Pelanggan" icon="o-users" link="/pelanggan" />
                <x-mary-menu-item title="Pemakaian" icon="o-bolt" link="/pemakaian" />
                <x-mary-menu-item title="Pembayaran" icon="o-credit-card" link="/pembayaran" />
                <x-mary-menu-item title="Transaksi" icon="o-cog-6-tooth" link="/transaksi" />
                @endif

                {{-- Menu Umum --}}
                {{-- <x-mary-menu-sub title="Settings" icon="o-cog-6-tooth">
                        <x-mary-menu-item title="Wifi" icon="o-wifi" link="####" />
                        <label class="flex cursor-pointer gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="5" />
                                <path
                                    d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
                            </svg>
                            <input type="checkbox" value="synthwave" class="toggle theme-controller" />
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                            </svg>
                        </label>
                        <x-mary-menu-item title="Archives" icon="o-archive-box" link="####" />
                    </x-mary-menu-sub> --}}
                <x-mary-menu-sub title="Settings" icon="o-cog-6-tooth">
                    <x-mary-menu-item title="Profile" icon="m-user-circle" :href="route('profile')" wire:navigate />
                    <livewire:layout.logout-button />
                </x-mary-menu-sub>

                @endif
            </x-mary-menu>

        </x-slot:sidebar>


        {{-- The $slot goes here --}}
        <x-slot:content>
            <!-- Page Heading -->
            @if (isset($header))
            <header>
                <div>
                    {{ $header }}
                </div>
            </header>
            @endif

            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- Toast --}}
    <x-mary-toast />

    <x-mary-spotlight />

    @livewireScripts
</body>

</html>