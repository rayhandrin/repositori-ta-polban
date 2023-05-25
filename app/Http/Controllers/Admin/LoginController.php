<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * # Controller untuk menangani fungsi-fungsi autentikasi admin dari website.
 */
class LoginController extends Controller
{
    /**
     * Fungsi untuk menampilkan halaman login.
     */
    public function index()
    {
        return view('admin.login');
    }

    /**
     * Fungsi untuk menangani autentikasi admin.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        /**
         * Fungsi untuk melakukan proses otentikasi pengguna berdasarkan kredensial yang diberikan.
         * Mengaembalikan boolean.
         */
        if (Auth::attempt($credentials)) {
            /**
             * Fungsi untuk menghasilkan token sesi yang baru. 
             * Membantu meningkatkan keamanan aplikasi dengan secara otomatis memperbarui token sesi setelah tindakan
             * penting, seperti otentikasi atau akses yang sensitif.
             */
            $request->session()->regenerate();

            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'message' => 'Akun tidak ditemukan.',
        ]);
    }

    /**
     * Fungsi untuk menangani keluar sesi admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Fungsi untuk melakukan proses keluar dari sesi autentikasi admin yang sudah login.
        Auth::logout();

        // Fungsi untuk menghapus sesi pengguna saat ini. Ini menghapus semua data sesi yang terkait dengan pengguna yang sedang terautentikasi.
        $request->session()->invalidate();

        // Fungsi untuk menghasilkan token baru untuk sesi pengguna, untuk melindungi sesi dari serangan CSRF.
        $request->session()->regenerateToken();

        return redirect('/admin')->with('message', 'Anda berhasil logout.');
    }
}
