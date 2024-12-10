<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenawaranController extends Controller
{
    public function index()
    {
        return view('penawaran');
    }

    public function getPenawaran(Request $request)
    {
        $data = Penawaran::select(['id', 'nama_item', 'qty', 'belanja', 'ongkir', 'total', 'net', '10%', 'penawaran', 'untung', 'untung_belanja', 'ariba', 'created_at']);
        if ($request->filled('penawaran_filter')) {
            $data->whereDate('created_at', $request->penawaran_filter);
        }
        $datatable = DataTables::eloquent($data)
            ->addIndexColumn()
            ->make(true);
        return $datatable;
    }

    public function createPenawaran(Request $request)
    {
        try {
            $messages = [
                'required' => ':attribute harus diisi',
            ];
            $request->validate([
                'nama_item' => 'required',
                'qty' => 'required',
                'belanja' => 'required',
                'ongkir' => 'required',
            ], $messages);

            $namaItem = $request->input('nama_item');
            $qty = $request->input('qty');
            $belanja = $request->input('belanja');
            $ongkir = $request->input('ongkir');
            $total = $belanja * $qty + $ongkir;
            $net = $total / $qty;
            $sepuluhPersen = $net * 0.10;
            $penawaran = $sepuluhPersen + $net;
            $untung = $penawaran * $qty;
            $untungBelanja = $untung - $total;

            DB::beginTransaction();
            $createPenawaran = Penawaran::create([
                'nama_item' => $namaItem,
                'qty' => $qty,
                'belanja' => $belanja,
                'ongkir' => $ongkir,
                'total' => $total,
                'net' => $net,
                '10%' => $sepuluhPersen,
                'penawaran' => $penawaran,
                'untung' => $untung,
                'untung_belanja' => $untungBelanja,
            ]);
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data penawaran berhasil ditambahkan',
                'data' => $createPenawaran
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

    public function editPenawaran($id)
    {
        try {
            $editPenawaran = Penawaran::findOrFail($id);
            $response = [
                'status' => 'success',
                'message' => 'data berhasil diambil',
                'data' => $editPenawaran
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
        return \response()->json($response);
    }

    public function updatePenawaran(Request $request, $id)
    {
        try {
            $messages = [
                'required' => ':attribute harus diisi',
            ];

            $request->validate([
                'nama_item' => 'required',
                'qty' => 'required|numeric',
                'belanja' => 'required|numeric',
                'ongkir' => 'required|numeric',
            ], $messages);

            $editPenawaran = Penawaran::findOrFail($id);

            $namaItem = $request->input('nama_item');
            $qty = $request->input('qty');
            $belanja = $request->input('belanja');
            $ongkir = $request->input('ongkir');

            $total = $belanja * $qty + $ongkir;
            $net = $total / $qty;
            $sepuluhPersen = $net * 0.10;
            $penawaran = $sepuluhPersen + $net;
            $untung = $penawaran * $qty;
            $untungBelanja = $untung - $total;

            $dataToUpdate = [
                'nama_item' => $namaItem,
                'qty' => $qty,
                'belanja' => $belanja,
                'ongkir' => $ongkir,
                'total' => $total,
                'net' => $net,
                '10%' => $sepuluhPersen,
                'penawaran' => $penawaran,
                'untung' => $untung,
                'untung_belanja' => $untungBelanja
            ];

            DB::beginTransaction();
            $editPenawaran->update($dataToUpdate);
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data penawaran berhasil diperbarui'
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
        return response()->json($response);
    }

    public function deletePenawaran($id)
    {
        try {
            $penawaran = Penawaran::findOrFail($id);
            DB::beginTransaction();
            $penawaran->delete();
            DB::commit();
            $response = [
                'status' => 'success',
                'message' => 'Data penawaran berhasil dihapus'
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
        $data = Penawaran::select(['id', 'nama_item', 'qty', 'belanja', 'ongkir', 'total', 'net', 'penawaran', 'untung', 'untung_belanja', 'ariba', 'created_at']);
        if ($request->filled('penawaran_filter')) {
            $data->whereDate('created_at', Carbon::parse($request->penawaran_filter)->format('Y-m-d'));
        }
        if ($request->filled('penawaran_filter')) {
            $dateFilter = Carbon::parse($request->penawaran_filter)->format('d-m-Y');
        } else {
            $dateFilter = "-- -- --";
        }
        $penawaran = $data->get();
        $pdf = Pdf::loadView('pdf.laporan-penawaran-pdf', compact('penawaran', 'dateFilter'))->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-penawaran.pdf');
    }

    public function updateAriba(Request $request)
    {
        try {
            $id = $request->id;
            $ariba = $request->ariba;

            $penawaran = Penawaran::findOrFail($id);
            $penawaran->ariba = $ariba;
            $penawaran->save();
            $response = [
                'status' => 'success',
                'message' => 'Upah berhasil diupdate',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Gagal mengupdate upah',
                'error' => $e->getMessage(),
            ];
        }
        return \response()->json($response);
    }
}
