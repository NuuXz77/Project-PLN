<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-secondary dark:text-gray-200 leading-tight">
            <x-mary-header title="Dashboard" separator />
        </h2>
    </x-slot>
    
    <div>
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-3">
                <!-- Card 1 -->
                <x-mary-card class="bg-white dark:bg-secondary" title="Pelanggan" subtitle="123" shadow separator>
                    <i class="fas fa-users text-4xl"></i>
                </x-mary-card>

                <!-- Card 2 -->
                <x-mary-card class="bg-white dark:bg-secondary" title="Pemakaian" subtitle="456" shadow separator>
                    <i class="fas fa-bolt text-4xl"></i>
                </x-mary-card>

                <!-- Card 3 -->
                <x-mary-card class="bg-white dark:bg-secondary" title="Pembayaran" subtitle="789" shadow separator>
                    <i class="fas fa-credit-card text-4xl"></i>
                </x-mary-card>

                <!-- Card 4 -->
                <x-mary-card class="bg-white dark:bg-secondary" title="Transaksi" subtitle="369" shadow separator>
                    <i class="fas fa-money-bill-wave text-4xl"></i>
                </x-mary-card>
            </div>

            @php
                $slides = [
                    [
                        'image' => 'https://web.pln.co.id/statics/uploads/2024/12/fa-nataru.png',
                    ],
                    [
                        'image' => 'https://web.pln.co.id/statics/uploads/2024/11/banner-hln.jpg',
                    ],
                    [
                        'image' => 'https://web.pln.co.id/statics/uploads/2024/10/JA_WebBanner-1920x556_311024.jpg',
                    ],
                    [
                        'image' => 'https://web.pln.co.id/statics/uploads/2024/03/Kalender-Banner_1920x556px.jpg',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 p-3">
                <x-mary-carousel class="bg-white dark:bg-secondary" :slides="$slides" />
            </div>
            

            <!-- Grafik Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3">
                <div class="bg-white dark:bg-secondary p-3 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Total Pendapatan</h3>
                    <p class="text-lg">237.000.000/bln</p>
                    <i class="fas fa-chart-bar text-6xl"></i>
                </div>

                <div class="bg-white dark:bg-secondary p-3 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold">Distribusi Transaksi</h3>
                    <i class="fas fa-chart-pie text-6xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    @if(session('status') == 'Login successful!')
        <div id="toast" class="toast flex flex-wrap justify-center">
            <div class="alert alert-info flex items-center">
                <span class="mr-2">Login Success</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                </svg>
            </div>
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('toast').style.display = 'none';
            }, 3000);
        </script>
    @endif
</x-layouts.app>
