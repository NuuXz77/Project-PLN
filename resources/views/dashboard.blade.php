<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            <x-mary-header title="Dashboard" separator />
        </h2>
    </x-slot>

    <div>
        <livewire:pelanggan.statiska-info />
    </div>

    <!-- <div class="p-6"> -->
    <!-- Chart Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Column Chart (3/4 width) -->
        <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-3 h-[300px] bg-white dark:bg-base-100">
            <h3 class="text-lg font-semibold mb-4 text-gray-500">
                Total Pembayaran
            </h3>
            <livewire:livewire-column-chart
                :column-chart-model="$columnChart"
                wire:key="{{ $filterType }}-chart" />
            <form method="GET" action="{{ url()->current() }}" class="mb-16">
                <div class="flex items-center space-x-4">
                    <span class="font-medium text-gray-500">Tampilkan Data :</span>
                    <select
                        name="filter_type"
                        onchange="this.form.submit()"
                        class="border rounded-lg px-8 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-base-100">
                        <option value="bulanan" {{ $filterType == 'bulanan' ? 'selected' : '' }}>
                            Per Bulan
                        </option>
                        <option value="tahunan" {{ $filterType == 'tahunan' ? 'selected' : '' }}>
                            Per Tahun
                        </option>
                    </select>

                    <!-- Info Tahun Tersedia -->
                    <span class="text-sm text-gray-500">
                        @if($filterType == 'tahunan' && $availableYears->isNotEmpty())
                        (Data tersedia: {{ $availableYears->first() }} - {{ $availableYears->last() }})
                        @endif
                    </span>
                </div>
            </form>
        </div>

        <!-- Pie Chart (1/4 width) -->
        <div class="bg-white rounded-xl shadow-md p-6 h-[300px] mb-10 bg-white dark:bg-base-100">
            <h3 class="text-lg font-semibold mb-4 text-gray-500">
                Jenis Pelanggan
            </h3>
            <livewire:livewire-pie-chart
                :pie-chart-model="$pieChart"
                wire:key="jenis-pelanggan-chart" />
        </div>
    </div>
    <div class="mt-10">
        <livewire:pelanggan-teratas />
    </div>

    @if(session('status') == 'Login successful!')
    <div id="toast" class="toast flex flex-wrap justify-center">
        <div class="alert alert-info flex items-center">
            <span class="mr-2">Login Success</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
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