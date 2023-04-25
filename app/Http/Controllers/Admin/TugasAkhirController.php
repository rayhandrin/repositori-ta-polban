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
            'cover' => 'required|file',
            'bab_1' => 'required|file',
            'bab_2' => 'required|file',
            'bab_5' => 'required|file',
            'kelengkapan' => 'required|file',
            'bab_3' => 'nullable|file',
            'bab_4' => 'nullable|file',
            'opsional_1' => 'nullable|file',
            'opsional_2' => 'nullable|file',
        ]);

        $data_tugas_akhir = Arr::only($validated, ['judul', 'tahun', 'kata_kunci', 'kontributor_1', 'kontributor_2', 'kontributor_3']);
        $id = date('YmdHis');
        $data_tugas_akhir['id'] = $id;
        $data_tugas_akhir['staf_perpus_pengunggah'] = Auth::user()->nama;
        $data_mahasiswa = Arr::only($validated, ['mahasiswa_1', 'mahasiswa_2', 'mahasiswa_3']);
        $data_dokumen = Arr::only($validated, ['cover', 'bab_1', 'bab_2', 'bab_5', 'kelengkapan', 'bab_3', 'bab_4', 'opsional_1', 'opsional_2']);

        $filepath = [];
        foreach ($data_dokumen as $key => $dokumen) {
            $filename = $dokumen->getClientOriginalName();
            $path = Storage::putFileAs('tugas-akhir/' . $id, $dokumen, $filename);
            $filepath[$key] = $path;
        }
        $data_tugas_akhir['filepath'] = $filepath;

        DB::transaction(function () use ($data_tugas_akhir, $data_mahasiswa, $data_dokumen, $id) {
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
        // $data = TugasAkhir::findOrFail($id);
        // dd($data);
        return view('admin.tugas-akhir.show', [
            'tugas_akhir' => TugasAkhir::findOrFail($id)
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
        try {
            Storage::disk('tugas-akhir')->deleteDirectory($id);
            TugasAkhir::destroy($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return redirect()->route('admin.tugas-akhir.index')->with('message', 'Data tugas akhir berhasil dihapus!');
    }

    public function viewFile($path)
    {
        abort_if(
            !Storage::disk('tugas-akhir')->exists($path),
            404,
            "The file doesn't exist. Check the path."
        );

        return Storage::disk('tugas-akhir')->response($path);
    }
}
