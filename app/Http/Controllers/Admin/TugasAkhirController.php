<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class TugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tugas-akhir.index', [
            'tugas_akhir' => TugasAkhir::paginate(10)
        ]);
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
        $data_tugas_akhir = $request->only(['judul', 'tahun', 'kata_kunci', 'kontributor_1', 'kontributor_2', 'kontributor_3']);
        $id = date('YmdHis');
        $data_tugas_akhir['id'] = $id;
        $data_tugas_akhir['admin_username'] = 'admin1'; // logged in admin
        $data_mahasiswa = $request->only(['mahasiswa1', 'mahasiswa2', 'mahasiswa3']);
        $data_dokumen = $request->only(['dokumen_1', 'dokumen_2', 'dokumen_3', 'dokumen_4', 'dokumen_opsional_1', 'dokumen_opsional_2']);

        DB::transaction(function () use ($data_tugas_akhir, $data_mahasiswa, $data_dokumen, $id) {
            TugasAkhir::create($data_tugas_akhir);

            Mahasiswa::whereIn('nim', $data_mahasiswa)->update(['tugas_akhir_id' => $id]);

            $data_path = [];
            foreach ($data_dokumen as $key => $dokumen) {
                $filename = $dokumen->getClientOriginalName();
                $path = Storage::putFileAs('tugas-akhir/' . $id, $dokumen, $filename);
                $data_path[$key] = $path;
            }
            $data_path['tugas_akhir_id'] = $id;
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
        // $data = TugasAkhir::with(['mahasiswa', 'dokumen'])->findOrFail($id);
        // dd($data);
        return view('admin.tugas-akhir.show', [
            'tugas_akhir' => TugasAkhir::with(['mahasiswa', 'dokumen'])->findOrFail($id)
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
        TugasAkhir::destroy($id);

        return redirect()->route('admin.tugas-akhir.index')->with('message', 'Data tugas akhir berhasil dihapus!');
    }

    public function accessFile($filename)
    {
        $path = storage_path($filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
