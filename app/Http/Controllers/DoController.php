<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;
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
        $datatable = DataTables::eloquent($data)->addIndexColumn()->make(true);
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
            $data = Perusahaan::create($request->all());
            DB::commit();
            $response = [
                'status' => 'success',
                'data' => $data,
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
}
