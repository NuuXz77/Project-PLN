<x-layouts.page>
    <div class="flex items-center justify-center">
        <div class="hero bg-base-200 w-full">
            <div class="hero-content text-center">
                <div class="max-w-2xl sm:max-w-full">
                    <h1 class="text-5xl font-bold mb-4">Cek Segera Tagihan Anda!</h1>
                    <p class="text-lg mb-6">
                        Jangan lupa, jika telat Anda pasti dapat denda. Bayar segera karena itu adalah hutang.
                    </p>
                    <div class="flex justify-center">
                        <x-mary-header>
                            <livewire:search-tagihan.input-search>
                        </x-mary-header>
                    </div>
                    <div>
                        <x-mary-card title="Struk Pembayaran Tagihan Listrik" subtitle="Detail Pembayaran" shadow separator>
                            <div class="space-y-4">
                                <!-- Informasi Pelanggan -->
                                <div>
                                    <p class="font-bold">NO. RESI : 12656919</p>
                                    <p>IDPEL : 231000632715</p>
                                    <p>NAMA : DJJOK SUNARTO</p>
                                    <p>TARIF/DAYA : R1/900 VA</p>
                                    <p>BL/TH : APR12</p>
                                </div>

                                <!-- Stand Meter -->
                                <div>
                                    <p class="font-bold">STAND METER</p>
                                    <p>01578200 - 01602800</p>
                                </div>

                                <!-- Detail Pembayaran -->
                                <div>
                                    <p class="font-bold">DETAIL PEMBAYARAN</p>
                                    <p>NON SUBSIDI : Rp 0</p>
                                    <p>RP TAG PLN : Rp 145.375</p>
                                    <p>ADMIN BANK : Rp 1.600</p>
                                    <p class="font-bold">TOTAL BAYAR : Rp 146.975</p>
                                </div>

                                <!-- Informasi Tambahan -->
                                <div>
                                    <p class="text-sm">PLN MENYATAKAN STRUK INI SEBAGAI BUKTI PEMBAYARAN YANG SAH, HARAP DISIMPAN.</p>
                                    <p class="text-sm">INFORMASI PLN HUB : 123</p>
                                </div>
                            </div>
                        </x-mary-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.page>