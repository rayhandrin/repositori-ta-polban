<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;

/**
 * # Controller untuk menangani fungsi-fungsi TA untuk mobile.
 */
class TugasAkhirAPIController extends Controller
{
    /**
     * Fungsi untuk mendapatkan semua daftar jurusan.
     */
    public function jurusan()
    {
        $jurusan = ProgramStudi::distinct('jurusan')->pluck('jurusan');
        return response()->json($jurusan);
    }

    /**
     * Fungsi untuk mendapatkan daftar program studi berdasarkan jurusan.
     */
    public function prodi($jurusan)
    {
        $program_studi = ProgramStudi::where('jurusan', $jurusan)->get(['nama', 'diploma', 'nomor']);
        return response()->json($program_studi);
    }

    /**
     * Fungsi untuk mendapatkan daftar tugas akhir berdasarkan program studi.
     */
    public function tugasAkhir($nomor_prodi)
    {
        $tugas_akhir = Mahasiswa::with('tugasAkhir:id,judul')->where('program_studi_nomor', $nomor_prodi)->distinct('tugas_akhir_id')->get(['tugas_akhir_id']);
        return response()->json($tugas_akhir);
    }

    /**
     * Fungsi untuk mendapatkan detail tugas akhir berdasarkan id.
     */
    public function tugasAkhirDetail($id)
    {
        $tugas_akhir = TugasAkhir::with('mahasiswa:nim,nama,tugas_akhir_id')->find($id);
        return response()->json($tugas_akhir);
    }
}
