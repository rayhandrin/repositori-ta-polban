<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaAktif;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|numeric|digits:9|unique:mahasiswa_aktif,nim',
            'nama' => 'required|regex:/^[a-zA-Z\s]*$/|max:50',
            'jurusan' => 'required|string|max:50',
            'program_studi' => 'required|string|max:70',
            'angkatan' => 'required|numeric|digits:4',
            'email' => 'required|email|unique:mahasiswa_aktif,email|ends_with:polban.ac.id',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        $data = $request->except('password_confirmation');
        $data['password'] = Hash::make($data['password']);

        try {
            $mahasiswa = MahasiswaAktif::create($data);
            event(new Registered($mahasiswa));

            return response()->json(['message' => 'Registrasi berhasil.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Registrasi gagal.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        $mahasiswa = MahasiswaAktif::find($request->nim);

        if (!$mahasiswa || !Hash::check($request->password, $mahasiswa->password)) {
            return response()->json(['message' => 'NIM / kata sandi salah.'], 401);
        }

        if (!$mahasiswa->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email belum terverifikasi.'], 401);
        }

        $token = $mahasiswa->createToken('secret')->plainTextToken;

        return response()->json([
            'message' => 'Berhasil login.',
            'mahasiswa' => $mahasiswa,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout berhasil.']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'Logout gagal.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json(['message' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return response()->json(['message' => __($status)]);
    }
}
