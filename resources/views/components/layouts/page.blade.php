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
<body class="min-h-screen font-sans antialiased bg-gray-200 dark:bg-base-200">
    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky full-width>
        <x-slot:brand>
            <div class="ml-5 pt-5">
                <img src="{{asset('img/Logo_PLN.svg')}}" alt="" width="90">
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
        {{-- Sidebar hanya muncul pada layar mobile --}}
        <x-slot:sidebar sticky drawer="main-drawer" collapsible class="bg-base-200 lg:hidden">
            {{-- Activates the menu item when a route matches the `link` property --}}
            <x-mary-menu activate-by-route>
                <x-mary-menu-item title="Home" icon="o-home" link="###" />
                <x-mary-menu-item title="Messages" icon="o-envelope" link="###" />
                <x-mary-menu-sub title="Settings" icon="o-cog-6-tooth">
                    <x-mary-menu-item title="Wifi" icon="o-wifi" link="####" />
                    <x-mary-menu-item title="Archives" icon="o-archive-box" link="####" />
                </x-mary-menu-sub>
            </x-mary-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
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