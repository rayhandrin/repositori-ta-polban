<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        try {
            $mahasiswa = Mahasiswa::find($request->route('id'));

            if ($mahasiswa->hasVerifiedEmail()) {
                throw new \Exception('Email sudah terverifikasi.');
            }

            if (!hash_equals((string) $request->route('hash'), sha1($mahasiswa->getEmailForVerification()))) {
                throw new AuthorizationException;
            }

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
