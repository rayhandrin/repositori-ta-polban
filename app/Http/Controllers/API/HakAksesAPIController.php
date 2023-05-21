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

class HakAksesAPIController extends Controller
{
    public function getHakAksesMahasiswa($nim)
    {
        $hak_akses = HakAkses::with('tugasAkhir:id,judul')->where('mahasiswa_nim', $nim)->get(['id', 'tugas_akhir_id']);
        return response()->json($hak_akses);
    }

    public function createHakAkses(Request $request, $nim)
    {
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

        $tugas_akhir = TugasAkhir::find($validated['tugas_akhir_id']);
        if (!$tugas_akhir) {
            return response()->json([
                'message' => 'ID Tugas Akhir tidak terdaftar.',
            ], 404);
        }

        $id = date('YmdHis');
        $data = [
            'id' => $id,
            'diminta_pada' => Carbon::now(),
            'mahasiswa_nim' => $nim,
            'tugas_akhir_id' => $validated['tugas_akhir_id']
        ];

        try {
            $filename = $id . '.' . $validated['foto_surat']->getClientOriginalExtension();
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

    public function getDetailHistory($id)
    {
        $hak_akses = HakAkses::find($id);
        return response()->json($hak_akses);
    }
}
