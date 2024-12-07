<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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
        try {
            $data = Invoice::select('invoice.id as id_invoice', 'invoice.nomor_invoice', 'invoice.do_id', 'perusahaan.id as id_perusahaan', 'perusahaan.nama_perusahaan as nama_perusahaan')->join('perusahaan', 'invoice.perusahaan_id', '=', 'perusahaan.id');
            if ($request->filled('invoice_filter')) {
                $data->whereDate('invoice.created_at', $request->invoice_filter);
            }
            $datatable = DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
            return $datatable;
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat data invoice',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function cetakInvoice($id)
    {
        try {
            $data = Invoice::select('invoice.id as id_invoice', 'invoice.nomor_invoice', 'invoice.do_id', 'perusahaan.id', 'perusahaan.nama_perusahaan', 'perusahaan.alamat')
                ->where('invoice.id', $id)
                ->join('perusahaan', 'invoice.perusahaan_id', '=', 'perusahaan.id')
                ->first();

            if (!$data) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invoice tidak ditemukan',
                ]);
            }

            $orderIds = json_decode($data->do_id);
            if (empty($orderIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada surat jalan terkait dengan invoice ini.',
                ]);
            }

            $manyData = DB::table('order_items')
                ->join('surat_jalan', 'order_items.surat_jalan_id', '=', 'surat_jalan.id')
                ->whereIn('surat_jalan.id', $orderIds)
                ->select(
                'surat_jalan.nomor_po',
                'order_items.kode_barang',
                'order_items.nama_barang',
                'order_items.jumlah_barang',
                'order_items.satuan',
                'order_items.harga_barang'
            )
                ->orderBy('surat_jalan.nomor_po')
                ->get();

            $totalHargaBarang = $manyData->sum(fn($item) => $item->jumlah_barang * $item->harga_barang);
            $angkaTerbilang = $this->formatTerbilangRupiah($totalHargaBarang);
            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $currentDate = Carbon::now()->format('d') . ' ' . $bulan[Carbon::now()->format('m') - 1] . ' ' . Carbon::now()->format('Y');
            $pdf = Pdf::loadView('pdf.laporan-inv-pdf', compact('data', 'manyData', 'totalHargaBarang', 'currentDate', 'angkaTerbilang'))
            ->setPaper('a4', 'portrait');
            return $pdf->stream('laporan-inv.pdf');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mencetak invoice',
                'error' => $th->getMessage()
            ]);
        }
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

    public function listInvoice(Request $request)
    {
        try {
            DB::beginTransaction();
            $noInvoice = Invoice::select('nomor_invoice')->get();
            $search = $request->input('search');
            $data = SuratJalan::whereNotIn('nomor_invoice', $noInvoice)
                ->when($search, function ($query, $search) {
                    return $query->where('nomor_invoice', 'LIKE', "%{$search}%");
                })
                ->select('nomor_invoice', DB::raw('MIN(id) as id'))
                ->groupBy('nomor_invoice')
                ->get();
            DB::commit();
            $response = [
                'status' => 'success',
                'data' => $data,
                'message' => 'List nomor invoice berhasil diload'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'List nomor invoice gagal diload',
                'error' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function listDo()
    {
        try {
            $deliveryOrders = DB::table('surat_jalan')
                ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->select(
                    'surat_jalan.id',
                    'surat_jalan.nomor_surat_jalan',
                    'surat_jalan.nomor_invoice',
                    'surat_jalan.nomor_po',
                    'order_items.kode_barang',
                    'order_items.nama_barang',
                    'order_items.harga_barang',
                    'order_items.satuan',
                    'order_items.jumlah_barang',
                    'order_items.keterangan'
                )
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('invoice')
                        ->whereRaw('JSON_SEARCH(invoice.do_id, \'one\', CAST(surat_jalan.id AS CHAR)) IS NOT NULL');
                })
                ->get();

            $response = $deliveryOrders->groupBy('nomor_surat_jalan')->map(function ($items, $nomorSuratJalan) {
                return [
                    'nomor_surat_jalan' => $nomorSuratJalan,
                    'nomor_invoice' => $items->first()->nomor_invoice,
                    'nomor_po' => $items->first()->nomor_po,
                    'id' => $items->first()->id,
                    'items' => $items->map(function ($item) {
                        return [
                            'kode_barang' => $item->kode_barang,
                            'nama_barang' => $item->nama_barang,
                            'harga_barang' => $item->harga_barang,
                            'satuan' => $item->satuan,
                            'jumlah_barang' => $item->jumlah_barang,
                            'keterangan' => $item->keterangan ?? '-',
                        ];
                    }),
                ];
            })->values();
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal load DO',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function createInvoice(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'nomor_invoice' => 'required|string|unique:invoice,nomor_invoice',
                'perusahaan_id' => 'required',
                'do_id' => 'required|array',
            ]);
            Invoice::create([
                'nomor_invoice' => $request->nomor_invoice,
                'perusahaan_id' => $request->perusahaan_id,
                'do_id' => json_encode($request->do_id)
            ]);
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Invoice berhasil dibuat',
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            $response = [
                'status' => 'error',
                'message' => 'Invoice gagal dibuat',
                'error' => $th->getMessage()
            ];
        }
        return \response()->json($response);
    }

    public function editInv($id)
    {
        try {
            $invoices = Invoice::join('perusahaan', 'invoice.perusahaan_id', '=', 'perusahaan.id')
            ->join('surat_jalan', function ($join) {
                $join->whereRaw("JSON_SEARCH(invoice.do_id, 'one', CAST(surat_jalan.id AS CHAR)) IS NOT NULL")
                ->orWhereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('invoice')
                        ->whereRaw('JSON_SEARCH(invoice.do_id, \'one\', CAST(surat_jalan.id AS CHAR)) IS NOT NULL');
                });
            })
                ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->select(
                    'invoice.id as id_invoice',
                    'invoice.nomor_invoice',
                    'perusahaan.id as id_perusahaan',
                    'perusahaan.nama_perusahaan',
                    DB::raw('JSON_UNQUOTE(JSON_EXTRACT(invoice.do_id, JSON_UNQUOTE(JSON_SEARCH(invoice.do_id, \'one\', CAST(surat_jalan.id AS CHAR))))) as do_id'),
                    'surat_jalan.id as id_surat_jalan',
                    'surat_jalan.nomor_surat_jalan',
                    'surat_jalan.nomor_po',
                    'order_items.kode_barang',
                    'order_items.nama_barang',
                    'order_items.harga_barang',
                    'order_items.satuan',
                    'order_items.jumlah_barang',
                    'order_items.keterangan',
                    'order_items.surat_jalan_id'
                )
                ->where('invoice.id', $id)
                ->get();

            $invoice = $invoices->groupBy('nomor_surat_jalan')->map(function ($items, $nomorSuratJalan) {
                return [
                    'nomor_surat_jalan' => $nomorSuratJalan,
                    'nomor_invoice' => $items->first()->nomor_invoice,
                    'nomor_po' => $items->first()->nomor_po,
                    'id_invoice' => $items->first()->id_invoice,
                    'nama_perusahaan' => $items->first()->nama_perusahaan,
                    'id_perusahaan' => $items->first()->id_perusahaan,
                    'do_id' => $items->first()->do_id,
                    'id_surat_jalan' => $items->first()->id_surat_jalan,
                    'items' => $items->map(function ($item) {
                        return [
                            'kode_barang' => $item->kode_barang,
                            'nama_barang' => $item->nama_barang,
                            'harga_barang' => $item->harga_barang,
                            'satuan' => $item->satuan,
                            'jumlah_barang' => $item->jumlah_barang,
                            'keterangan' => $item->keterangan ?? '-',
                            'surat_jalan_id' => $item->surat_jalan_id
                        ];
                    }),
                ];
            })->values();

            $response = [
                'status' => 'success',
                'data' => $invoice,
                'message' => 'Data invoice berhasil didapatkan'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => 'Data invoice gagal didapatkan',
                'error' => $th->getMessage()
            ];
        }
        return \response()->json($response);
    }

    public function updateInv(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $messages = [
                'nomor_invoice.required' => 'Nomor Invoice harus diisi',
                'nomor_invoice.string' => 'Nomor Invoice harus berupa string',
                'nomor_invoice.unique' => 'Nomor Invoice sudah digunakan',
                'perusahaan_id.required' => 'Perusahaan harus diisi',
                'do_id.required' => 'Delivery Order harus diisi',
                'do_id.array' => 'Delivery Order harus berupa array',
                'do_id.min' => 'Minimal 1 Delivery Order harus diisi',
            ];
            $request->validate([
                'nomor_invoice' => 'required|string|unique:invoice,nomor_invoice,' . $id,
                'perusahaan_id' => 'required',
                'do_id' => 'required|array|min:1',
            ], $messages);
            $nomorInvoice = $request->input('nomor_invoice');
            $perusahaanId = $request->input('perusahaan_id');
            $doIds = $request->input('do_id');
            $invoice = Invoice::findOrFail($id);
            $invoice->nomor_invoice = $nomorInvoice;
            $invoice->perusahaan_id = $perusahaanId;
            $invoice->do_id = json_encode($doIds);
            $invoice->save();
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Invoice berhasil diperbarui!'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'Gagal memperbarui invoice.',
                'error' => $e->getMessage()
            ];
        }
        return \response()->json($response);
    }

    public function deleteInvoice($id)
    {
        try {
            DB::beginTransaction();
            Invoice::findOrFail($id)->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Invoice gagal dihapus',
                'error' => $th->getMessage(),
            ]);
        }
        return response()->json($response);
    }
}
