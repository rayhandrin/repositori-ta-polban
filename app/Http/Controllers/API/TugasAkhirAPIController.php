<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;

class TugasAkhirAPIController extends Controller
{
    public function jurusan()
    {
        $jurusan = ProgramStudi::distinct('jurusan')->pluck('jurusan');
        return response()->json($jurusan);
    }

    public function prodi($jurusan)
    {
        $program_studi = ProgramStudi::where('jurusan', $jurusan)->get(['nama', 'diploma', 'nomor']);
        return response()->json($program_studi);
    }

    public function tugasAkhir($nomor_prodi)
    {
        $tugas_akhir = Mahasiswa::with('tugasAkhir:id,judul')->where('program_studi_nomor', $nomor_prodi)->distinct('tugas_akhir_id')->get(['tugas_akhir_id']);
        return response()->json($tugas_akhir);
    }

    public function tugasAkhirDetail($id)
    {
        $tugas_akhir = TugasAkhir::with('mahasiswa:nim,nama,tugas_akhir_id')->find($id);
        return response()->json($tugas_akhir);
    }
}
