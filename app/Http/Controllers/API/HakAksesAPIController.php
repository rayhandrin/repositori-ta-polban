<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HakAkses;
use App\Models\TugasAkhir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * # Controller untuk menangani fungsi-fungsi pengaksesan file TA yang dibatasi.
 */
class HakAksesAPIController extends Controller
{
    /**
     * Fungsi untuk mendapatkan history pengajuan hak akses mahasiswa berdasarkan nim.
     */
    public function getHakAksesMahasiswa($nim)
    {
        $hak_akses = HakAkses::with('tugasAkhir:id,judul')->where('mahasiswa_nim', $nim)->get(['id', 'tugas_akhir_id']);
        return response()->json($hak_akses);
    }

    /**
     * Fungsi untuk membuat pengajuan hak akses oleh mahasiswa.
     */
    public function createHakAkses(Request $request, $nim)
    {
        // Memvalidasi inputan pengguna.
        $validator = Validator::make($request->all(), [
            'tugas_akhir_id' => 'required|integer|digits:14',
            'foto_surat' => 'required|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        // Mengecek apakah TA yang diajukan ada pada sistem.
        $tugas_akhir = TugasAkhir::find($validated['tugas_akhir_id']);
        if (!$tugas_akhir) {
            return response()->json([
                'message' => 'ID Tugas Akhir tidak terdaftar.',
            ], 404);
        }

        // Menyiapkan data hak akses.
        $id = date('YmdHis');
        $data = [
            'id' => $id,
            'diminta_pada' => Carbon::now(),
            'mahasiswa_nim' => $nim,
            'tugas_akhir_id' => $validated['tugas_akhir_id']
        ];

        try {
            // Menyiapkan filename berdasarkan id hak akses (datetime dibuat).
            $filename = $id . '.' . $validated['foto_surat']->getClientOriginalExtension();
            /**
             * Menyimpan data hak akses dan mengupload file gambar ke server.
             * Dibungkus dalam DB Transaction agar menjadi transaksi yang atomic (tunggal).
             */
            DB::transaction(function () use ($data, $nim, $validated, $filename) {
                HakAkses::create($data);
                Storage::disk('hak-akses')->putFileAs($nim, $validated['foto_surat'], $filename);
            });

            return response()->json(['message' => 'Pengajuan hak akses berhasil.'], 201);
        } catch (\Throwable $t) {
            Log::error($t->getMessage());

            return response()->json([
                'message' => 'Pengajuan hak akses gagal.',
                'error' => $t->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi menampilkan detail history pengajuan.
     */
    public function getDetailHistory($id)
    {
        $hak_akses = HakAkses::find($id);
        return response()->json($hak_akses);
    }
}
