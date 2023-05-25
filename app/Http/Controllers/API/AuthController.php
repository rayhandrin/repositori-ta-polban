<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\SendOTP;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * # Controller untuk menangani fungsi-fungsi autentikasi mahasiswa dari mobile.
 */
class AuthController extends Controller
{
    /**
     * Fungsi untuk menambahkan mahasiswa baru yang mendaftar dari mobile.
     * 
     * @param Request
     */
    public function register(Request $request)
    {
        // Memvalidasi inputan pengguna.
        $validator = Validator::make($request->all(), [
            'nim' => 'required|integer|digits:9|unique:mahasiswa,nim',
            'nama' => 'required|regex:/^[a-zA-Z\s\.]*$/|max:50',
            'email' => 'required|email|unique:mahasiswa,email|ends_with:polban.ac.id|max:50',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        /**
         * Mengecek apakah nomor prodi dari nim yang diinputkan terdaftar pada sistem.
         * Jika tidak, mahasiswa tidak bisa mendaftar.
         */
        $nomor_prodi = substr($validated['nim'], 2, 4);
        $program_studi = ProgramStudi::find($nomor_prodi);
        if (!$program_studi) {
            return response()->json([
                'message' => 'Nomor program studi tidak terdaftar untuk NIM tersebut.',
            ], 404);
        }

        $data = Arr::except($validated, 'password_confirmation');
        $data['password'] = Hash::make($data['password']);
        $data['status_aktif'] = true;
        $data['program_studi_nomor'] = $nomor_prodi;

        try {
            /**
             * Meng-insert data mahasiswa yang berhasil tervalidasi.
             * Memicu event Registered untuk mengirimkan email verifikasi ke alamat email mahasiswa.
             * Dibungkus dalam DB Transaction agar menjadi transaksi yang atomic (tunggal).
             */
            DB::transaction(function () use ($data) {
                $mahasiswa = Mahasiswa::create($data);
                event(new Registered($mahasiswa));
            });

            return response()->json(['message' => 'Registrasi berhasil.'], 201);
        } catch (\Throwable $t) {
            Log::error($t->getMessage());

            return response()->json([
                'message' => 'Registrasi gagal.',
                'error' => $t->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi untuk mengautentikasi mahasiswa yang akan mengakses aplikasi mobile.
     * 
     * @param Request
     */
    public function login(Request $request)
    {
        // Memvalidasi inputan pengguna.
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

        $validated = $validator->validated();

        // Mencari mahasiswa berdasarkan nim.
        $mahasiswa = Mahasiswa::find($validated['nim']);

        // Jika nim atau password salah, kembalikan respon.
        if (!$mahasiswa || !Hash::check($validated['password'], $mahasiswa->password)) {
            return response()->json(['message' => 'NIM / kata sandi salah.'], 401);
        }

        // Jika email belum diverifikasi, kembalikan respon.
        if (!$mahasiswa->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email belum terverifikasi.'], 401);
        }

        // Membuat akses token berdasarkan nim.
        $token = $mahasiswa->createToken('secret' . $mahasiswa->nim)->plainTextToken;

        return response()->json([
            'message' => 'Berhasil login.',
            'mahasiswa' => $mahasiswa,
            'token' => $token
        ]);
    }

    /**
     * Fungsi untuk mengeluarkan mahasiswa dari sesi.
     * 
     * @param Request
     */
    public function logout(Request $request)
    {
        try {
            // Menghapus akses token mahasiswa yang melakukan request ini.
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Logout berhasil.']);
        } catch (\Throwable $t) {
            Log::error($t->getMessage());

            return response()->json([
                'message' => 'Logout gagal.',
                'error' => $t->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi untuk mengirimkan kode OTP ke email mahasiswa yang akan mengatur ulang kata sandi.
     * 
     * @param Request
     */
    public function forgotPassword(Request $request)
    {
        // Memvalidasi inputan pengguna.
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:mahasiswa,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            /**
             * Men-generate 4 angka random untuk kode OTP.
             * Kode disimpan di database dengan email mahasiswa yang me-request-nya.
             * Mengirimkan kode OTP melalui email mahasiswa.
             * Dibungkus dalam DB Transaction agar menjadi transaksi yang atomic (tunggal).
             */
            $otp = rand(1000, 9999);
            DB::transaction(function () use ($request, $otp) {
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'otp' => $otp,
                    'created_at' => Carbon::now()
                ]);
                Mail::to($request->email)->send(new SendOTP($otp));
            });

            return response()->json(['message' => 'Kode OTP berhasil dikirim.']);
        } catch (\Throwable $t) {
            Log::error($t->getMessage());

            return response()->json([
                'message' => 'Kode OTP gagal dikirim.',
                'error' => $t->getMessage()
            ], 500);
        }
    }

    /**
     * Fungsi untuk memverifikasi kode OTP yang dikirim mahasiswa dengan yang terdaftar di database.
     * 
     * @param Request
     */
    public function verifyOTP(Request $request)
    {
        // Memvalidasi inputan pengguna.
        $validator = Validator::make($request->all(), [
            'otp' => 'required|integer|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        // Mengecek otp yang dikirimkan di database.
        $result = DB::select("SELECT * FROM password_resets WHERE otp = ?", [$request->otp]);

        // Jika database tidak ditemukan, kembalikan respon.
        if (!$result) {
            return response()->json(['message' => 'Kode OTP tidak valid.'], 404);
        }

        return response()->json([
            'message' => 'Kode OTP valid.',
            'email' => $result[0]->email
        ]);
    }

    /**
     * Fungsi untuk mengatur ulang kata sandi mahasiwa yang kode OTP-nya berhasil diverifikasi.
     * 
     * @param Request
     */
    public function resetPassword(Request $request)
    {
        // Memvalidasi inputan pengguna.
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error validasi.',
                'errors' => $validator->errors()
            ], 400);
        }

        $validated = $validator->validated();

        try {
            /**
             * Mengambil data mahasiswa berdasarkan nim.
             * Mengubah password mahasiswa.
             */
            $mahasiswa = Mahasiswa::where('email', $validated['email'])->first();
            $mahasiswa->password = Hash::make($validated['password']);

            /**
             * Menyimpan hasil perubahan password dan menghapus otp dari database.
             * Dibungkus dalam DB Transaction agar menjadi transaksi yang atomic (tunggal).
             */
            DB::transaction(function () use ($mahasiswa) {
                $mahasiswa->save();
                DB::table('password_resets')->where('email', $mahasiswa->email)->delete();
            });

            return response()->json(['message' => 'Kata sandi berhasil diatur ulang.']);
        } catch (\Throwable $t) {
            Log::error($t->getMessage());

            return response()->json([
                'message' => 'Kata sandi gagal diatur ulang.',
                'error' => $t->getMessage()
            ], 500);
        }
    }
}
