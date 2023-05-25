<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MahasiswaDataTable;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * # Controller untuk menangani fungsi-fungsi pengelolaan 
 * # data mahasiswa oleh admin dari website.
 */
class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MahasiswaDataTable $dataTable)
    {
        return $dataTable->render('admin.mahasiswa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Memvalidasi inputan pengguna.
        $validated = $request->validate([
            'nim' => 'required|integer|digits:9|unique:mahasiswa,nim',
            'nama' => 'required|regex:/^[a-zA-Z\s\.]*$/',
            'email' => 'nullable|email|unique:mahasiswa,email|ends_with:polban.ac.id|required_with:status_aktif',
            'password' => 'nullable|min:6|required_with:email',
            'status_aktif' => 'nullable|required_with:email'
        ]);

        /**
         * Mengecek apakah nomor prodi dari nim yang diinputkan terdaftar pada sistem.
         * Jika tidak, mahasiswa tidak bisa mendaftar.
         */
        $nomor_prodi = substr($validated['nim'], 2, 4);
        $program_studi = ProgramStudi::find($nomor_prodi);
        if (!$program_studi) {
            return back()->withErrors([
                'nim' => 'Nomor program studi tidak terdaftar untuk NIM tersebut.'
            ])->withInput();
        }

        $validated['program_studi_nomor'] = $nomor_prodi;
        /**
         * Mengecek apakah terdapat password pada request.
         * Jika ada, Hash passwordnya.
         */
        $validated['password'] = (isset($validated['password'])) ? Hash::make($validated['password']) : null;

        try {
            /**
             * Mengecek apakah ada status_aktif pada request.
             * status_aktif menunjukkan mahasiswa tersebut alumni atau aktif.
             * Jika ada status_aktif, kirim verifikasi akun ke email mahasiswa.
             */
            if (array_key_exists('status_aktif', $validated)) {
                DB::transaction(function () use ($validated) {
                    $mahasiswa = Mahasiswa::create($validated);
                    event(new Registered($mahasiswa));
                });
            } else {
                Mahasiswa::create($validated);
            }

            return redirect()->route('admin.mahasiswa.index')->with('message', 'Data mahasiswa berhasil ditambah!');
        } catch (\Throwable $t) {
            Log::error($t->getMessage());

            return redirect()->route('admin.mahasiswa.index')->with('message', 'Data mahasiswa gagal ditambah!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::with('programStudi:nomor,nama')->findOrFail($id);
        return view('admin.mahasiswa.show', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nim' => [
                'required', 'integer', 'digits:9',
                Rule::unique('mahasiswa', 'nim')->ignore($id, 'nim')
            ],
            'nama' => 'required|regex:/^[a-zA-Z\s\.]*$/',
            'email' => [
                'nullable', 'email', 'ends_with:polban.ac.id', 'required_with:status_aktif',
                Rule::unique('mahasiswa', 'email')->ignore($id, 'nim')
            ],
            'password' => 'nullable|min:6',
            'status_aktif' => 'nullable|required_with:email'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mahasiswa::destroy($id);

        return redirect()->route('admin.mahasiswa.index')->with('message', 'Data mahasiswa berhasil dihapus!');
    }
}
