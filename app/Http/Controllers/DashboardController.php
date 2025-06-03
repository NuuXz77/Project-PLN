<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filterType = $request->input('filter_type', 'bulanan'); // Default bulanan

        $chart = (new ColumnChartModel())
            ->setTitle('Total Pembayaran')
            ->setAnimated(true);

        if ($filterType === 'tahunan') {
            // Ambil data tahunan
            $data = Pembayaran::selectRaw('YEAR(created_at) as label, SUM(TotalBayar) as total')
                ->groupBy('label')
                ->orderBy('label')
                ->get();

            foreach ($data as $item) {
                $chart->addColumn($item->label, $item->total, '#3B82F6');
            }
        } else {
            // Ambil data bulanan
            $data = Pembayaran::selectRaw('DATE_FORMAT(created_at, "%b %Y") as label, SUM(TotalBayar) as total')
                ->groupBy('label')
                ->orderByRaw('MIN(created_at)')
                ->get();

            foreach ($data as $item) {
                $chart->addColumn($item->label, $item->total, '#10B981');
            }
        }

        //chart Pie
        // 1. Ambil data jumlah pelanggan per jenis
        $dataPelanggan = Pelanggan::selectRaw('Jenis_Plg, COUNT(*) as total')
            ->groupBy('Jenis_Plg')
            ->get();

        // 2. Hitung total semua pelanggan
        $totalPelanggan = Pelanggan::count();

        // 3. Buat Pie Chart
        $pieChart = (new PieChartModel())
            ->setAnimated(true)
            ->withDataLabels(true);

        // 4. Definisikan warna dan mapping jenis
        $jenisMapping = [
            'RT' => ['label' => 'Rumah Tangga', 'color' => '#3B82F6'],
            'BSN' => ['label' => 'Bisnis', 'color' => '#10B981'],
            'IND' => ['label' => 'Industri', 'color' => '#F59E0B']
        ];

        // 5. Tambahkan data ke chart
        foreach ($dataPelanggan as $item) {
            $jenis = $jenisMapping[$item->Jenis_Plg] ?? [
                'label' => $item->Jenis_Plg,
                'color' => '#94A3B8'
            ];

            $persentase = $totalPelanggan > 0
                ? round(($item->total / $totalPelanggan) * 100, 1)
                : 0;

            $pieChart->addSlice(
                "{$jenis['label']} ($persentase%)",
                $item->total,
                $jenis['color']
            );
        }

        return view('dashboard', [
            'columnChart' => $chart,
            'filterType' => $filterType,
            'pieChart' => $pieChart,
            'availableYears' => $this->getAvailableYears() // Tetap sebagai Collection
        ]);
    }

    private function getChartData($filterType)
    {
        $chart = (new ColumnChartModel())->setTitle('Total Pembayaran');

        if ($filterType === 'tahunan') {
            $data = Pembayaran::selectRaw('YEAR(created_at) as tahun, SUM(TotalBayar) as total')
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->get();

            foreach ($data as $item) {
                $chart->addColumn($item->tahun, $item->total, '#3B82F6');
            }

            return [
                'chart' => $chart,
                'labels' => $data->pluck('tahun'),
                'data' => $data->pluck('total')
            ];
        } else { // Bulanan
            $data = Pembayaran::selectRaw('DATE_FORMAT(created_at, "%b %Y") as bulan_tahun, SUM(TotalBayar) as total')
                ->groupBy('bulan_tahun')
                ->orderByRaw('MIN(created_at)')
                ->get();

            foreach ($data as $item) {
                $chart->addColumn($item->bulan_tahun, $item->total, '#10B981');
            }

            return [
                'chart' => $chart,
                'labels' => $data->pluck('bulan_tahun'),
                'data' => $data->pluck('total')
            ];
        }
    }

    private function getAvailableYears()
    {
        return Pembayaran::selectRaw('YEAR(created_at) as tahun')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->pluck('tahun');
    }
}
