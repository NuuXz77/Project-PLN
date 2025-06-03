<div>
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 bg-white dark:bg-base-100">
        <h3 class="text-lg font-semibold mb-4 text-gray-500">
            Pelanggan Teratas
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 bg-white dark:bg-base-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pemakaian (kWh)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white dark:bg-base-100">
                    @foreach($pelangganTeratas as $index => $pelanggan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pelanggan->Nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($pelanggan->total_pemakaian) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>