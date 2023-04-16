<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;

class TugasAkhirAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tugas_akhir = TugasAkhir::with('firstMahasiswa.programStudi:nomor,jurusan')->limit(10)->get(['id', 'judul']);
        return response()->json($tugas_akhir);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tugas_akhir = TugasAkhir::with(['dokumen', 'mahasiswa:nim,nama,tugas_akhir_id'])->find($id);
        return response()->json($tugas_akhir);
    }
}
