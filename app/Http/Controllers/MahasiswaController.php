<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.mahasiswa.index', [
            'mahasiswa' => Mahasiswa::paginate(10)
        ]);
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
        $data = $request->except('_token');
        $data['program_studi_nomor'] = substr($data['nim'], 2, 4);
        $data['password'] = Hash::make($data['password']);

        try {
            if (array_key_exists('status_aktif', $data)) {
                DB::transaction(function () use ($data) {
                    $mahasiswa = Mahasiswa::create($data);
                    event(new Registered($mahasiswa));
                });
            } else {
                Mahasiswa::create($data);
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
        return view('admin.mahasiswa.show', [
            'mahasiswa' => Mahasiswa::findOrFail($id)
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
        Mahasiswa::destroy($id);

        return redirect()->route('admin.mahasiswa.index')->with('message', 'Data mahasiswa berhasil dihapus!');
    }
}
