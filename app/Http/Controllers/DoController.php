<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\SuratJalan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DoController extends Controller
{
    public function index()
    {
        return view('delivery-order');
    }

    public function getPerusahaan()
    {
        $data = Perusahaan::select(['id', 'alamat', 'nama_perusahaan', 'no_hp', 'npwp']);
        $datatable = DataTables::of($data)->addIndexColumn()->make(true);
        return $datatable;
    }

    public function createPerusahaan(Request $request)
    {
        try {
            $messages = [
                'required' => ':attribute wajib diisi'
            ];
            $request->validate([
                'nama_perusahaan' => 'required',
            ], $messages);
            DB::beginTransaction();
            Perusahaan::create($request->all());
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data perusahaan berhasil ditambahkan'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function editPerusahaan($id)
    {
        try {
            $editPerusahaan = Perusahaan::findOrFail($id);
            $response = [
                'status' => 'success',
                'message' => 'data berhasil diambil',
                'data' => $editPerusahaan
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
        return \response()->json($response);
    }

    public function updatePerusahaan(Request $request, $id)
    {
        try {
            $messages = [
                'required' => ':attribute wajib diisi'
            ];
            $request->validate([
                'nama_perusahaan' => 'required',
            ], $messages);
            DB::beginTransaction();
            $editPerusahaan = Perusahaan::findOrFail($id);
            $editPerusahaan->update($request->all());
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'data berhasil diupdate',
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'data gagal diupdate',
                'error' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function deletePerusahaan($id)
    {
        try {
            $perusahaan = Perusahaan::findOrFail($id);
            DB::beginTransaction();
            $perusahaan->delete();
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data perusahaan berhasil dihapus'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
        return \response()->json($response);
    }

    public function getListPerusahaan(Request $request)
    {
        try {
            DB::beginTransaction();
            $search = $request->input('search');
            $data = Perusahaan::when($search, function ($query, $search) {
                return $query->where('nama_perusahaan', 'LIKE', "%{$search}%");
            })->limit(10)->get();
            DB::commit();
            $response = [
                'status' => 'success',
                'data' => $data,
                'message' => 'List perusahaan berhasil diload'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'List perusahaan gagal diload',
                'error' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function getNoSuratJalan()
    {
        try {
            DB::beginTransaction();
            $currentYear = Carbon::now()->year;
            $lastNumber = SuratJalan::whereYear('tanggal', $currentYear)
                ->orderByRaw("CAST(SUBSTRING_INDEX(nomor_surat_jalan, '/', -1) AS UNSIGNED) DESC")
                ->first();
            $nextNumber = $lastNumber ? (int)explode('/', $lastNumber->nomor_surat_jalan)[2] + 1 : 1;
            $nomorSuratJalan = sprintf("DO/%s/%s", $currentYear, $nextNumber);
            DB::commit();
            $response = [
                'status' => 'success',
                'data' => $nomorSuratJalan,
                'message' => 'Nomor surat jalan berhasil didapatkan'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'Nomor surat jalan gagal didapatkan',
                'error' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function getNoInv()
    {
        try {
            DB::beginTransaction();
            $romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            $month = $romanNumerals[Carbon::now()->month - 1];
            $year = Carbon::now()->year;
            $noInvoice = \sprintf(".../INV/PT.KSS/%s/%s", $month, $year);
            DB::commit();
            $response = [
                'status' => 'success',
                'data' => $noInvoice,
                'message' => 'Nomor invoice berhasil didapatkan'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => 'Nomor invoice gagal didapatkan',
                'error' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function createDo(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'min' => ':attribute minimal :min',
        ];
        $request->validate([
            'nomor_surat_jalan' => 'required',
            'nomor_invoice' => 'required',
            'tanggal' => 'required',
            'nomor_po' => 'required',
            'transportasi_kirim' => 'required',
            'nomor_polisi' => 'required',
            'kode_barang' => 'required',
            'kode_barang.*' => 'required',
            'nama_barang' => 'required',
            'nama_barang.*' => 'required',
            'harga_barang' => 'required',
            'harga_barang.*' => 'required',
            'satuan' => 'required',
            'satuan.*' => 'required',
            'jumlah_barang' => 'required|min:1',
            'jumlah_barang.*' => 'required|min:1',
            'keterangan' => 'nullable',
            'perusahaan_id' => 'required',
        ], $messages);
        DB::beginTransaction();
        try {
            $suratJalan = SuratJalan::create([
                'nomor_surat_jalan' => $request->nomor_surat_jalan,
                'nomor_invoice' => $request->nomor_invoice,
                'tanggal' => $request->tanggal,
                'nomor_po' => $request->nomor_po,
                'transportasi_kirim' => $request->transportasi_kirim,
                'nomor_polisi' => $request->nomor_polisi,
            ]);
            foreach ($request->harga_barang as $index => $harga) {
                $hargaBersih = str_replace('.', '', $harga);
                OrderItems::create([
                    'harga_barang' => $hargaBersih,
                    'kode_barang' => $request->kode_barang[$index],
                    'nama_barang' => $request->nama_barang[$index],
                    'satuan' => $request->satuan[$index],
                    'jumlah_barang' => $request->jumlah_barang[$index],
                    'keterangan' => $request->keterangan[$index] ?? null,
                    'surat_jalan_id' => $suratJalan->id,
                    'perusahaan_id' => $request->perusahaan_id,
                ]);
            }
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Delivery order berhasil dibuat',
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'Sepertinya ada masalah',
                'error' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function getDo(Request $request)
    {
        $data = OrderItems::select(
            'surat_jalan.id as surat_jalan_id',
            'surat_jalan.nomor_surat_jalan as nomor_surat_jalan',
            'perusahaan.nama_perusahaan as nama_perusahaan',
        )
            ->join('surat_jalan', 'order_items.surat_jalan_id', '=', 'surat_jalan.id')
            ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
            ->groupBy('surat_jalan_id', 'surat_jalan.nomor_surat_jalan', 'perusahaan.nama_perusahaan');
        if ($request->filled('do_filter')) {
            $data->whereDate('surat_jalan.tanggal', $request->do_filter);
        }
        $datatable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        return $datatable;
    }

    public function editDo($id)
    {
        try {
            $suratJalan = DB::table('surat_jalan')
                ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
                ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
                ->where('surat_jalan.id', $id)
                ->select(
                    'surat_jalan.*',
                    'order_items.kode_barang',
                    'order_items.nama_barang',
                'order_items.harga_barang',
                    'order_items.satuan',
                    'order_items.jumlah_barang',
                    'order_items.keterangan',
                    'order_items.perusahaan_id',
                    'perusahaan.nama_perusahaan as nama_perusahaan'
                )
                ->get();
            $response = [
                'status' => 'success',
                'data' => $suratJalan,
                'message' => 'Data delivery order berhasil didapatkan'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => 'Data delivery order gagal didapatkan',
                'error' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function updateDo(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $messages = [
                'required' => ':attribute wajib diisi',
                'min' => ':attribute minimal :min',
            ];
            $request->validate([
                'perusahaan_id' => 'required',
                'nomor_surat_jalan' => 'required',
                'nomor_invoice' => 'required',
                'tanggal' => 'required|date',
                'nomor_po' => 'required',
                'transportasi_kirim' => 'required',
                'nomor_polisi' => 'required',
                'kode_barang.*' => 'required',
                'nama_barang.*' => 'required',
                'harga_barang.*' => 'required',
                'satuan.*' => 'required',
                'jumlah_barang.*' => 'required|integer|min:1',
                'keterangan.*' => 'nullable',
            ], $messages);
            DB::table('surat_jalan')->where('id', $id)->update([
                'nomor_surat_jalan' => $request->nomor_surat_jalan,
                'nomor_invoice' => $request->nomor_invoice,
                'tanggal' => $request->tanggal,
                'nomor_po' => $request->nomor_po,
                'transportasi_kirim' => $request->transportasi_kirim,
                'nomor_polisi' => $request->nomor_polisi,
            ]);
            DB::table('order_items')->where('surat_jalan_id', $id)->delete();
            foreach ($request->harga_barang as $index => $harga) {
                $hargaBersih = str_replace('.', '', $harga);
                DB::table('order_items')->insert([
                    'surat_jalan_id' => $id,
                    'kode_barang' => $request->kode_barang[$index],
                    'nama_barang' => $request->nama_barang[$index],
                    'harga_barang' => $hargaBersih,
                    'satuan' => $request->satuan[$index],
                    'jumlah_barang' => $request->jumlah_barang[$index],
                    'keterangan' => $request->keterangan[$index] ?? null,
                    'perusahaan_id' => $request->perusahaan_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data delivery order berhasil diperbarui',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'Data delivery order gagal diperbarui',
                'error' => $e->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function deleteDo($id)
    {
        try {
            DB::beginTransaction();
            $do = SuratJalan::findOrFail($id);
            $do->delete();
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data delivery order berhasil dihapus'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'Data delivery order gagal dihapus',
                'error' => $th->getMessage(),
            ];
        }
        return \response()->json($response);
    }

    public function cetakDo($id)
    {
        $data =
            DB::table('surat_jalan')
            ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
            ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
            ->where('surat_jalan.id', $id)
            ->select(
                'surat_jalan.*',
                'order_items.perusahaan_id',
                'perusahaan.nama_perusahaan',
                'perusahaan.alamat'
            )
            ->first();
        $manyData = DB::table('surat_jalan')
        ->join('order_items', 'surat_jalan.id', '=', 'order_items.surat_jalan_id')
        ->join('perusahaan', 'order_items.perusahaan_id', '=', 'perusahaan.id')
        ->where('surat_jalan.id', $id)
            ->select(
                'surat_jalan.*',
                'order_items.kode_barang',
                'order_items.nama_barang',
                'order_items.harga_barang',
                'order_items.satuan',
                'order_items.jumlah_barang',
                'order_items.keterangan',
                'order_items.perusahaan_id',
                'perusahaan.nama_perusahaan',
                'perusahaan.alamat'
            )
            ->get();
        $pdf = Pdf::loadView('pdf.laporan-do-pdf', \compact('data', 'manyData'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-do.pdf');
    }
}
