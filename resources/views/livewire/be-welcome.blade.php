<div class="min-h-screen from-blue-50 to-gray-50 py-8 px-4 sm:px-6 lg:px-8 bg-gray-200 dark:bg-base-200">
    <div class="max-w-7xl mx-auto">
        <div class="rounded-xl shadow-lg overflow-hidden bg-gray-200 dark:bg-base-200">
            <!-- Header Section -->
            <div class="bg-primary px-6 py-4 print:hidden">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Payment Search</h1>
                    <div class="relative w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-primary-content/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <x-mary-input wire:model.live.debounce.500ms="search"
                            placeholder="Search by Control No only..."
                            class="w-full pl-10 bg-primary/90 text-white placeholder-primary-content/80 border-0 focus:ring-2 focus:ring-primary-content" />
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="px-6 py-4">
                @if($search)
                @if($pembayarans->count() > 0)
                <div class="flex flex-col items-center">
                    @foreach($pembayarans as $pembayaran)
                    <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6 print:shadow-none print:border-0 print:p-0 print:m-0 print:max-w-full print:w-full border border-gray-100 dark:border-gray-700">
                        <!-- Header Struk untuk cetak -->
                        <div class="bg-primary text-primary-content p-6 rounded-t-xl print:rounded-t-none mb-6 print:mb-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">STRUK PEMBAYARAN</h2>
                                    <p class="text-primary-content/80">No. Transaksi: TRX-{{ $pembayaran->ID_Pembayaran }}-{{ $pembayaran->No_Kontrol }}</p>
                                </div>
                                <div class="bg-white/10 p-2 rounded-full">
                                    <x-mary-icon name="o-document-text" class="w-8 h-8" />
                                </div>
                            </div>
                            <p class="text-xs text-primary-content/60 mt-2 print:text-sm">{{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <!-- Info Pelanggan -->
                        <div class="flex flex-col md:flex-row gap-6 mb-6 print:mb-4">
                            <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-primary/10 p-2 rounded-lg">
                                        <x-mary-icon name="o-user" class="text-primary w-6 h-6" />
                                    </div>
                                    <h3 class="font-bold text-lg">Informasi Pelanggan</h3>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No. Kontrol</p>
                                        <p class="font-medium">{{ $pembayaran->No_Kontrol }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">PLN</p>
                                        <p class="font-medium">{{ $pembayaran->Nama }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                                        <p class="font-medium">{{ $pembayaran->Alamat }}/p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Pelanggan</p>
                                        <p class="font-medium">{{ $pembayaran->Jenis_Plg }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Pembayaran -->
                            <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="bg-primary/10 p-2 rounded-lg">
                                        <x-mary-icon name="o-credit-card" class="text-primary w-6 h-6" />
                                    </div>
                                    <h3 class="font-bold text-lg">Detail Pembayaran</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Total Bayar</span>
                                        <span class="font-medium text-primary text-lg">Rp {{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Status</span>
                                        <x-mary-badge 
                                            :value="$pembayaran->pemakaian ? $pembayaran->pemakaian->StatusPembayaran : '-'" 
                                            @class([
                                                'badge-success' => $pembayaran->pemakaian && $pembayaran->pemakaian->StatusPembayaran === 'Lunas',
                                                'badge-warning' => $pembayaran->pemakaian && $pembayaran->pemakaian->StatusPembayaran === 'Menunggu Konfirmasi',
                                                'badge-error' => !$pembayaran->pemakaian || $pembayaran->pemakaian->StatusPembayaran === 'Gagal',
                                            ])
                                            class="badge-sm"
                                        />
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Tanggal Bayar</span>
                                        <span class="font-medium">
                                            {{ optional($pembayaran->created_at)->format('d/m/Y H:i') ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pemakaian -->
                        @if($pembayaran->pemakaian)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-5 mb-6 print:mb-4">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-primary/10 p-2 rounded-lg">
                                    <x-mary-icon name="o-bolt" class="text-primary w-6 h-6" />
                                </div>
                                <h3 class="font-bold text-lg">Informasi Pemakaian</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No. Pemakaian</p>
                                    <p class="font-medium">PMK-{{ $pembayaran->pemakaian->ID_Pemakaian }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Periode</p>
                                    <p class="font-medium">{{ optional($pembayaran->pemakaian->created_at)->format('d M Y') ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pemakaian Awal</p>
                                    <p class="font-medium">{{ $pembayaran->pemakaian-MeterAwal }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pemakaian Akhir</p>
                                    <p class="font-medium">{{ $pembayaran->pemakaian-MeterAkhir }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Pemakaian</p>
                                    <p class="font-medium text-primary">gg</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Total -->
                        <div class="bg-primary/10 p-4 rounded-lg mb-6 print:mb-4 border border-primary/20">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-lg">TOTAL PEMBAYARAN</span>
                                <span class="font-bold text-2xl text-primary">Rp {{ number_format($pembayaran->TotalBayar, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Footer Struk -->
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400 print:text-sm print:mt-8 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p>Terima kasih telah melakukan pembayaran</p>
                            <p class="mt-1">*Struk ini sah sebagai bukti pembayaran*</p>
                        </div>

                        <!-- Tombol Cetak (hanya muncul di layar) -->
                        <div class="mt-6 flex justify-center print:hidden gap-3">
                            <x-mary-button 
                                label="Kembali" 
                                @click="$wire.search = ''" 
                                class="btn-ghost" 
                            />
                            <x-mary-button
                                label="Cetak Struk" 
                                icon-right="o-printer" 
                                class="btn-primary" 
                                onclick="window.print()"
                            />
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <x-mary-icon name="o-document-magnifying-glass" class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No payments found</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search query</p>
                    <x-mary-button 
                        label="Kembali" 
                        @click="$wire.search = ''" 
                        class="btn-ghost mt-4" 
                    />
                </div>
                @endif
                @else
                <div class="text-center py-12">
                    <x-mary-icon name="o-magnifying-glass" class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">Search for payments</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter a control number to search</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>