<?php

namespace App\Http\Controllers;

use App\Models\PembelianBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PembelianBarangController extends Controller
{
    public function index()
    {
        return view('pembelian-barang');
    }

    public function getPembelian(Request $request)
    {
        try {
            $data = PembelianBarang::select([
                'id',
                'nama_item',
                'qty',
                'satuan',
                'harga_item',
                'created_at',
                DB::raw('CAST(qty AS DECIMAL(10,2)) * CAST(harga_item AS DECIMAL(10,2)) as total')
            ]);
            if ($request->filled('pembelian_filter')) {
                $data->whereDate('created_at', $request->pembelian_filter);
            }
            $datatable = DataTables::eloquent($data)
                ->addIndexColumn()
                ->make(true);
            return $datatable;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function createPembelian(Request $request)
    {
        try {
            $messages = [
                'required' => ':attribute harus diisi',
            ];
            $request->validate([
                'nama_item' => 'required',
                'qty' => 'required',
                'satuan' => 'required',
                'harga_item' => 'required',
            ], $messages);
            DB::beginTransaction();
            PembelianBarang::create($request->all());
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data pembelian berhasil ditambahkan'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => 'Data pembelian gagal ditambahkan',
                'error' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function editPembelian($id)
    {
        try {
            $editPembelian = PembelianBarang::findOrFail($id);
            $response = [
                'status' => 'success',
                'data' => $editPembelian
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
        return response()->json($response);
    }

    public function updatePembelian(Request $request, $id)
    {
        try {
            $messages = [
                'required' => ':attribute harus diisi',
            ];
            $request->validate([
                'nama_item' => 'required',
                'qty' => 'required',
                'satuan' => 'required',
                'harga_item' => 'required',
            ], $messages);
            DB::beginTransaction();
            $updatePembelian = PembelianBarang::findOrFail($id);
            $updatePembelian->update($request->all());
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data pembelian berhasil diperbarui'
            ];
        } catch (\Throwable $th) {
            DB::rollback();
            $response = [
                'status' => 'error',
                'message' => 'Data pembelian gagal diperbarui',
                'error' => $th->getMessage(),
            ];
        }
        return response()->json($response);
    }

    public function deletePembelian($id)
    {
        try {
            $pembelian = PembelianBarang::findOrFail($id);
            DB::beginTransaction();
            $pembelian->delete();
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data pembelian berhasil dihapus'
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

    public function exportPDF(Request $request)
    {
        $data = PembelianBarang::select(['id', 'nama_item', 'qty', 'satuan', 'harga_item', 'created_at', DB::raw('qty * harga_item as total')]);
        if ($request->filled('pembelian_filter')) {
            $data->whereDate('created_at', Carbon::parse($request->pembelian_filter)->format('Y-m-d'));
        }
        if ($request->filled('pembelian_filter')) {
            $dateFilter = Carbon::parse($request->pembelian_filter)->format('d-m-Y');
        } else {
            $dateFilter = "-- -- --";
        }
        $pembelian = $data->get();
        $pdf = Pdf::loadView('pdf.laporan-pembelian-pdf', compact('pembelian', 'dateFilter'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-pembelian.pdf');
    }
}
