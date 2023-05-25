<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

/**
 * # Controller untuk menangani verifikasi email mahasiswa yang mendaftar.
 */
class EmailVerificationController extends Controller
{
    /**
     * Fungsi untuk memverifikasi request verifikasi email mahasiswa.
     */
    public function verify(Request $request)
    {
        try {
            // Mengambil data mahasiswa berdasarkan id dari url.
            $mahasiswa = Mahasiswa::find($request->route('id'));

            // Mengecek jika email sudah diverivikasi, kembalikan respon.
            if ($mahasiswa->hasVerifiedEmail()) {
                throw new \Exception('Email sudah terverifikasi.');
            }

            // Mengecek jika kode hash tidak valid, kembalikan respon.
            if (!hash_equals((string) $request->route('hash'), sha1($mahasiswa->getEmailForVerification()))) {
                throw new AuthorizationException;
            }

            /**
             * Memverifikasi email mahasiswa.
             * Memicu event Verified.
             */
            if ($mahasiswa->markEmailAsVerified()) {
                event(new Verified($mahasiswa));
            }

            return response()->json(['message' => 'Email berhasil diverifikasi.']);
        } catch (\Throwable $t) {
            return response()->json([
                'message' => 'Email gagal diverifikasi.',
                'error' => $t->getMessage()
            ], 500);
        }
    }
}
