<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use App\Models\SuratJalan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $totalPemasukan = SuratJalan::join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->whereMonth('surat_jalan.tanggal', $currentMonth)
                ->sum('order_items.harga_barang');
            $totalPengeluaran = PembelianBarang::whereMonth('created_at', $currentMonth)
            ->selectRaw('SUM(CAST(harga_item AS DECIMAL(10,2)) * CAST(qty AS DECIMAL(10,2))) as total')
            ->value('total');
            $untungRugi = $totalPemasukan - $totalPengeluaran;
            $currentDate = now();
            $daysInMonth = $currentDate->daysInMonth;
            $days = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $days[] = Carbon::createFromDate($currentDate->year, $currentDate->month, $i)->format('j');
            }
            $dataPemasukan = SuratJalan::join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->selectRaw('DAY(surat_jalan.tanggal) as day, SUM(order_items.harga_barang) as total')
                ->whereMonth('surat_jalan.tanggal', $currentMonth)
                ->whereYear('surat_jalan.tanggal', $currentYear)
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');
            $dataPengeluaran = PembelianBarang::selectRaw('DAY(created_at) as day, SUM(harga_item * qty) as total')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');
            $dailyDataPemasukan = [];
            $dailyDataPengeluaran = [];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dailyDataPemasukan[] = $dataPemasukan->get($i, 0);
                $dailyDataPengeluaran[] = $dataPengeluaran->get($i, 0);
            }
            return view('dashboard', compact('totalPemasukan', 'days', 'dailyDataPemasukan', 'totalPengeluaran', 'dailyDataPengeluaran', 'untungRugi'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function filterChart(Request $request)
    {
        try {
            $timeFilter = $request->input('timeFilter');
            $currentYear = Carbon::now()->year;
            if ($timeFilter === "last-month") {
                $currentMonth = Carbon::now()->subMonth()->month;
                $currentYear = Carbon::now()->subMonth()->year;
            } elseif ($timeFilter === "this-year") {
                $currentMonth = null;
            } elseif ($timeFilter === "last-year") {
                $currentYear = Carbon::now()->subYear()->year;
                $currentMonth = null;
            } else {
                $currentMonth = Carbon::now()->month;
            }
            $queryPemasukan = SuratJalan::join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
            ->whereYear('surat_jalan.tanggal', $currentYear);
            if ($currentMonth) {
                $queryPemasukan->whereMonth('surat_jalan.tanggal', $currentMonth);
            }
            $totalPemasukan = $queryPemasukan->sum('order_items.harga_barang');
            $queryPengeluaran = PembelianBarang::whereYear('created_at', $currentYear);
            if ($currentMonth) {
                $queryPengeluaran->whereMonth('created_at', $currentMonth);
            }
            $totalPengeluaran = $queryPengeluaran->sum(DB::raw('harga_item * qty'));
            $untungRugi = $totalPemasukan - $totalPengeluaran;
            $days = [];
            $dailyDataPemasukan = [];
            $dailyDataPengeluaran = [];
            if ($timeFilter === "this-year" || $timeFilter === "last-year") {
                $dataPemasukan = SuratJalan::join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->selectRaw('MONTH(surat_jalan.tanggal) as month, SUM(order_items.harga_barang) as total')
                ->whereYear('surat_jalan.tanggal', $currentYear)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->pluck('total', 'month');
                $dataPengeluaran = PembelianBarang::selectRaw('MONTH(created_at) as month, SUM(harga_item * qty) as total')
                ->whereYear('created_at', $currentYear)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->pluck('total', 'month');
                for ($i = 1; $i <= 12; $i++) {
                    $days[] = Carbon::createFromDate($currentYear, $i)->format('F');
                    $dailyDataPemasukan[] = $dataPemasukan->get($i, 0);
                    $dailyDataPengeluaran[] = $dataPengeluaran->get($i, 0);
                }
            } else {
                $daysInMonth = Carbon::createFromDate($currentYear, $currentMonth)->daysInMonth;
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $days[] = Carbon::createFromDate($currentYear, $currentMonth, $i)->format('j');
                }
                $dataPemasukan = SuratJalan::join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->selectRaw('DAY(surat_jalan.tanggal) as day, SUM(order_items.harga_barang) as total')
                    ->whereYear('surat_jalan.tanggal', $currentYear)
                    ->whereMonth('surat_jalan.tanggal', $currentMonth)
                ->groupBy('day')
                    ->orderBy('day')
                    ->pluck('total', 'day');
                $dataPengeluaran = PembelianBarang::selectRaw('DAY(created_at) as day, SUM(harga_item * qty) as total')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $currentMonth)
                ->groupBy('day')
                    ->orderBy('day')
                    ->pluck('total', 'day');
                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $dailyDataPemasukan[] = $dataPemasukan->get($i, 0);
                    $dailyDataPengeluaran[] = $dataPengeluaran->get($i, 0);
                }
            }
            $response = [
                'status' => 'success',
                'days' => $days,
                'dailyDataPemasukan' => $dailyDataPemasukan,
                'dailyDataPengeluaran' => $dailyDataPengeluaran,
                'totalPemasukan' => $totalPemasukan,
                'totalPengeluaran' => $totalPengeluaran,
                'untungRugi' => $untungRugi
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => 'Data pembelian gagal ditambahkan',
                'error' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }
}
