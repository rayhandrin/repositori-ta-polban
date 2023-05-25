<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TugasAkhirDataTable;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * # Controller untuk menangani fungsi-fungsi pengelolaan 
 * # data tugas akhir oleh admin dari website.
 */
class TugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TugasAkhirDataTable $dataTable)
    {
        return $dataTable->render('admin.tugas-akhir.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tugas-akhir.create');
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
            'judul' => 'required|unique:tugas_akhir,judul',
            'tahun' => 'nullable|integer|digits:4',
            'kata_kunci' => 'nullable',
            'kontributor_1' => 'nullable',
            'kontributor_2' => 'nullable',
            'kontributor_3' => 'nullable',
            'mahasiswa_1' => 'required',
            'mahasiswa_2' => 'nullable',
            'mahasiswa_3' => 'nullable',
            'bab_1' => 'required|file',
            'bab_2' => 'required|file',
            'bab_5' => 'required|file',
            'kelengkapan' => 'required|file',
            'cover' => 'nullable|file',
            'bab_3' => 'nullable|file',
            'bab_4' => 'nullable|file',
            'opsional_1' => 'nullable|file',
            'opsional_2' => 'nullable|file',
        ]);

        // Memisahkan data tugas akhir, mahasiswa, dan dokumen dari request.
        $data_tugas_akhir = Arr::only($validated, ['judul', 'tahun', 'kata_kunci', 'kontributor_1', 'kontributor_2', 'kontributor_3']);
        $id = date('YmdHis');
        $data_tugas_akhir['id'] = $id;
        $data_tugas_akhir['staf_perpus_pengunggah'] = Auth::user()->nama;
        $data_mahasiswa = Arr::only($validated, ['mahasiswa_1', 'mahasiswa_2', 'mahasiswa_3']);
        $data_dokumen = Arr::only($validated, ['bab_1', 'bab_2', 'bab_5', 'kelengkapan', 'cover', 'bab_3', 'bab_4', 'opsional_1', 'opsional_2']);

        /**
         * Menyimpan file yang diupload, mengambil path-nya berdasarkan 
         * id tugas akhir untuk disimpan ke database.
         */
        $filepath = [];
        foreach ($data_dokumen as $key => $dokumen) {
            $filename = $dokumen->getClientOriginalName();
            $path = Storage::disk('tugas-akhir')->putFileAs($id, $dokumen, $filename);
            $filepath[$key] = $path;
        }
        $data_tugas_akhir['filepath'] = $filepath;

        /**
         * Menyimpan data tugas akhir, dan meng-update mahasiswa terkait.
         * Dibungkus dalam DB Transaction agar menjadi transaksi yang atomic (tunggal).
         */
        DB::transaction(function () use ($data_tugas_akhir, $data_mahasiswa, $id) {
            TugasAkhir::create($data_tugas_akhir);

            Mahasiswa::whereIn('nim', $data_mahasiswa)->update(['tugas_akhir_id' => $id]);
        });

        return redirect()->route('admin.tugas-akhir.index')->with('message', 'Data tugas akhir berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.tugas-akhir.show', [
            'tugas_akhir' => TugasAkhir::with('mahasiswa')->findOrFail($id)
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Menghapus file-file tugas akhir dari server.
         * Menghapus data tugas akhir dari database.
         */
        try {
            Storage::disk('tugas-akhir')->deleteDirectory($id);
            TugasAkhir::destroy($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return redirect()->route('admin.tugas-akhir.index')->with('message', 'Data tugas akhir berhasil dihapus!');
    }

    /**
     * Fungsi untuk menampilkan file tugas akhir mahasiswa
     * ke halaman admin berdasarkan path.
     */
    public function viewFile($path)
    {
        // Jika file tidak ditemukan, munculkan halaman error.
        abort_if(
            !Storage::disk('tugas-akhir')->exists($path),
            404,
            "File tidak ditemukan."
        );

        // Mengembalikan respon file jika file ditemukan.
        return Storage::disk('tugas-akhir')->response($path);
    }
}
