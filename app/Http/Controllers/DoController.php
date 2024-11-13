<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\SuratJalan;
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

    public function getNoSuratJalan()
    {
        try {
            DB::beginTransaction();
            $currentYear = Carbon::now()->year;
            $lastNumber = SuratJalan::whereYear('tanggal', $currentYear)->orderByRaw("CAST(SUBSTRING_INDEX(nomor_surat_jalan, ' / ', -1) AS UNSIGNED) DESC")
            ->first();;
            $nextNumber = $lastNumber ?
                (int)explode(' / ', $lastNumber->nomor_surat_jalan)[2] : 1;;
            $nomorSuratJalan = \sprintf("DO/%s/%s", $currentYear, $nextNumber);
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
        return \response()->json($response);
    }

    public function getNoInv()
    {
        try {
            DB::beginTransaction();
            $romanNumerals = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            $month = $romanNumerals[Carbon::now()->month - 1];
            $year = Carbon::now()->year;
            $noInvoice = \sprintf("(input)/inv/pt.(input)/%s/%s", $month, $year);
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
}
