<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\SuratJalan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice');
    }

    public function getInvoice(Request $request)
    {
        $data = OrderItems::selectRaw('max(surat_jalan.nomor_invoice) as nomor_invoice, perusahaan.nama_perusahaan, max(surat_jalan.created_at) as created_at, max(surat_jalan.id) as surat_jalan_id')
            ->join('surat_jalan', 'order_items.surat_jalan_id', '=', 'surat_jalan.id')
            ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
            ->groupBy('surat_jalan.nomor_invoice', 'perusahaan.nama_perusahaan');
        if ($request->filled('invoice_filter')) {
            $data->whereDate('surat_jalan.created_at', $request->invoice_filter);
        }
        $datatable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        return $datatable;
    }

    public function cetakInvoice($id)
    {
        $data = DB::table('surat_jalan')
            ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
            ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
            ->where('surat_jalan.id', $id)
            ->select(
                'surat_jalan.id',
                'surat_jalan.nomor_invoice',
                'order_items.perusahaan_id',
                'perusahaan.nama_perusahaan',
                'perusahaan.alamat'
            )
            ->first();
        $manyData =
            DB::table('surat_jalan')
            ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
            ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
            ->where('surat_jalan.nomor_invoice', $data->nomor_invoice)
            ->select(
                'surat_jalan.nomor_invoice',
                'surat_jalan.nomor_po',
                'surat_jalan.id as surat_jalan_id',
                'order_items.kode_barang',
                'order_items.nama_barang',
                'order_items.harga_barang',
                'order_items.satuan',
                'order_items.jumlah_barang',
                'order_items.keterangan',
                'perusahaan.nama_perusahaan',
                'perusahaan.alamat'
            )
            ->orderBy('surat_jalan.id')
            ->get();

        $totalHargaBarang = $manyData->sum('harga_barang');
        $angkaTerbilang = $this->formatTerbilangRupiah($totalHargaBarang);
        $currentDate = Carbon::now()->isoFormat('D MMMM YYYY');
        $pdf = Pdf::loadView('pdf.laporan-inv-pdf', compact('manyData', 'data', 'totalHargaBarang', 'angkaTerbilang', 'currentDate'));
        $pdf->set_option('isHtml5ParserEnabled', true);
        $pdf->set_option("isPhpEnabled", true);
        return $pdf->stream('laporan-inv.pdf');
    }

    private function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $hasil = "";

        if ($angka < 12) {
            $hasil = $huruf[$angka];
        } elseif ($angka < 20) {
            $hasil = $this->terbilang($angka - 10) . " belas";
        } elseif ($angka < 100) {
            $hasil = $this->terbilang((int)($angka / 10)) . " puluh " . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $hasil = "seratus " . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $hasil = $this->terbilang((int)($angka / 100)) . " ratus " . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $hasil = "seribu " . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $hasil = $this->terbilang((int)($angka / 1000)) . " ribu " . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $hasil = $this->terbilang((int)($angka / 1000000)) . " juta " . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $hasil = $this->terbilang((int)($angka / 1000000000)) . " milyar " . $this->terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $hasil = $this->terbilang((int)($angka / 1000000000000)) . " triliun " . $this->terbilang(fmod($angka, 1000000000000));
        }
        return trim($hasil);
    }

    private function formatTerbilangRupiah($angka)
    {
        return ucfirst($this->terbilang($angka)) . " rupiah";
    }
}
