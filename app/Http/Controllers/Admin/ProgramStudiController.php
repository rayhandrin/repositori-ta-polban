<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProgramStudiDataTable;
use App\Http\Controllers\Controller;
use App\Imports\ProgramStudiImport;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

/**
 * # Controller untuk menangani fungsi-fungsi pengelolaan 
 * # data program studi oleh admin dari website.
 */
class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProgramStudiDataTable $dataTable)
    {
        return $dataTable->render('admin.program-studi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.program-studi.create');
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
            'nomor' => 'required|integer|digits:4|unique:program_studi,nomor',
            'nama' => 'required|regex:/^[a-zA-Z\s\'\/]*$/||unique:program_studi,nama',
            'kode' => 'required|unique:program_studi,kode',
            'jurusan' => 'required|regex:/^[a-zA-Z\s]*$/',
            'diploma' => [
                'required',
                Rule::in(['D3', 'D4'])
            ],
        ]);

        // Meng-insert data program studi.
        ProgramStudi::create($validated);

        return redirect()->route('admin.program-studi.index')->with('message', 'Data program studi berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $program_studi = ProgramStudi::findOrFail($id);
        return view('admin.program-studi.edit', [
            'program_studi' => $program_studi
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
        // Memvalidasi inputan pengguna.
        $validated = $request->validate([
            'nomor' => [
                'required', 'integer', 'digits:4',
                Rule::unique('program_studi', 'nomor')->ignore($id, 'nomor')
            ],
            'nama' => [
                'required', 'regex:/^[a-zA-Z\s\'\/]*$/',
                Rule::unique('program_studi', 'nama')->ignore($id, 'nomor')
            ],
            'kode' => [
                'required',
                Rule::unique('program_studi', 'kode')->ignore($id, 'nomor')
            ],
            'jurusan' => 'required|regex:/^[a-zA-Z\s]*$/',
            'diploma' => [
                'required',
                Rule::in(['D3', 'D4'])
            ],
        ]);

        // Meng-update data program studi.
        $program_studi = ProgramStudi::find($id);
        $program_studi->update($validated);

        return redirect()->route('admin.program-studi.index')->with('message', 'Data program studi berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProgramStudi::destroy($id);

        return redirect()->route('admin.program-studi.index')->with('message', 'Data program studi berhasil dihapus!');
    }

    /**
     * Menampilkan halaman untuk mengimport data program studi.
     */
    public function importPage()
    {
        return view('admin.program-studi.import');
    }

    /**
     * Fungsi untuk men-download template file untuk import data
     * program studi.
     */
    public function downloadTemplate()
    {
        try {
            return Storage::download('template/Template_Program_Studi.xlsx');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Fungsi untuk meng-import / meng-insert data program studi
     * dari file template (bulk insert).
     */
    public function import(Request $request)
    {
        try {
            Excel::import(new ProgramStudiImport, $request->file('excel'));

            return redirect()->route('admin.program-studi.index')->with('message', 'Data program studi berhasil diimport.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            return redirect()->back()->with('failures', $failures);
        }
    }
}
