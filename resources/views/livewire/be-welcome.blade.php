<div class="min-h-screen from-blue-50 to-gray-50 py-8 px-4 sm:px-6 lg:px-8 bg-gray-200 dark:bg-base-200">
    <div class="max-w-7xl mx-auto">
        <div class="rounded-xl shadow-lg overflow-hidden bg-gray-200 dark:bg-base-200">
            <!-- Header Section -->
            <div class="bg-indigo-600 px-6 py-4 print:hidden">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Payment Search</h1>
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <x-mary-input wire:model.live.debounce.500ms="search"
                            placeholder="Search by Control No only..."
                            class="w-full pl-10 bg-indigo-500 text-white placeholder-indigo-300 border-0 focus:ring-2 focus:ring-indigo-300" />
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="px-6 py-4">
                @if($search)
                @if($pembayarans->count() > 0)
                <div class="flex flex-col items-center">
                    <!-- Struk Pembayaran (diperbaiki untuk cetak) -->
                    @foreach($pembayarans as $pembayaran)
                    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 mb-6 print:shadow-none print:border-0 print:p-0 print:m-0 print:max-w-full print:w-full">
                        <!-- Header Struk untuk cetak -->
                        <div class="text-center mb-6 print:mb-4 print:border-b print:border-gray-300 print:pb-4">
                            <h2 class="text-xl font-bold print:text-2xl">STRUK PEMBAYARAN</h2>
                            <p class="text-sm text-gray-500 print:text-base">No. Transaksi: TRX-{{ $pembayaran->ID_Pembayaran }}-{{ $pembayaran->No_Kontrol }}</p>
                            <p class="text-xs text-gray-400 mt-1 print:text-sm">{{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <!-- Garis pemisah -->
                        <div class="border-t-2 border-dashed border-gray-300 my-4 print:border-t print:border-solid"></div>

                        <!-- Info Pelanggan -->
                        <div class="mb-4 print:mb-3">
                            <h3 class="font-semibold text-gray-700 print:text-lg print:font-bold">INFORMASI PELANGGAN</h3>
                            <div class="grid grid-cols-2 gap-2 mt-2 print:grid-cols-3 print:gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 print:text-base">No. Kontrol</p>
                                    <p class="font-medium print:text-lg">{{ $pembayaran->No_Kontrol }}</p>
                                </div>
                                <div class="print:col-span-2">
                                    <p class="text-sm text-gray-600 print:text-base">Alamat</p>
                                    <p class="font-medium print:text-lg">Jl. Contoh No. 123, Kota Anda</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 print:text-base">Jenis Pelanggan</p>
                                    <p class="font-medium print:text-lg">Rumah Tangga</p>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Pembayaran -->
                        <div class="mb-6 print:mb-4">
                            <h3 class="font-semibold text-gray-700 print:text-lg print:font-bold">DETAIL PEMBAYARAN</h3>
                            <div class="mt-2 space-y-2 print:space-y-3">
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Total Bayar</span>
                                    <span class="font-medium print:text-xl">Rp {{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Status</span>
                                    <span class="font-medium {{ $pembayaran->pemakaian && $pembayaran->pemakaian->StatusPembayaran === 'Lunas' ? 'text-green-600' : 'text-red-600' }} print:text-lg">
                                        {{ $pembayaran->pemakaian ? $pembayaran->pemakaian->StatusPembayaran : '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Tanggal Bayar</span>
                                    <span class="font-medium print:text-lg">
                                        {{ optional($pembayaran->created_at)->format('d/m/Y H:i') ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pemakaian -->
                        @if($pembayaran->pemakaian)
                        <div class="mb-6 print:mb-4">
                            <h3 class="font-semibold text-gray-700 print:text-lg print:font-bold">INFORMASI PEMAKAIAN</h3>
                            <div class="mt-2 space-y-2 print:space-y-3">
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">No. Pemakaian</span>
                                    <span class="font-medium print:text-lg">PMK-{{ $pembayaran->pemakaian->ID_Pemakaian }}</span>
                                </div>
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Pemakaian Awal</span>
                                    <span class="font-medium print:text-lg">10 kWh</span>
                                </div>
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Pemakaian</span>
                                    <span class="font-medium print:text-lg">190 kWh</span>
                                </div>
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Periode</span>
                                    <span class="font-medium print:text-lg">{{ optional($pembayaran->pemakaian->created_at)->format('d M Y') ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between print:items-center">
                                    <span class="text-gray-600 print:text-base">Pemakaian Akhir</span>
                                    <span class="font-medium print:text-lg">200 kWh</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Total -->
                        <div class="bg-gray-100 p-3 rounded-lg mb-6 print:bg-gray-200 print:p-4 print:mb-4">
                            <div class="flex justify-between font-bold text-lg print:text-xl">
                                <span>TOTAL</span>
                                <span>Rp {{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Footer Struk -->
                        <div class="text-center text-xs text-gray-500 print:text-sm print:mt-8">
                            <p>Terima kasih telah melakukan pembayaran</p>
                            <p class="mt-1">*Struk ini sah sebagai bukti pembayaran*</p>
                        </div>

                        <!-- Tombol Cetak (hanya muncul di layar) -->
                        <div class="mt-6 flex justify-center print:hidden">
                            <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Cetak Struk
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <!-- <div class="mt-4 flex items-center justify-between">
                    
                </div> -->
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-200 dark:text-white">No payments found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search query</p>
                </div>
                @endif
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Search for payments</h3>
                    <p class="mt-1 text-sm text-gray-500">Enter a control number to search</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>