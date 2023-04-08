@extends('layouts.app')

@section('content')
    <div class="container-lg mb-5">
        <div class="row">
            <div class="col">
                <h3>Tambah Data Tugas Akhir</h3>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-10">
                <form action="{{ route('admin.tugas-akhir.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="on">
                    @csrf
                    <div class="row gx-5">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="tahun" name="tahun">
                            </div>
                            <div class="mb-3">
                                <label for="kata_kunci" class="form-label">Kata Kunci</label>
                                <input type="text" class="form-control" id="kata_kunci" name="kata_kunci">
                            </div>
                            <div class="mb-3">
                                <label for="kontributor_1" class="form-label">Kontributor 1</label>
                                <input type="text" class="form-control" id="kontributor_1" name="kontributor_1">
                            </div>
                            <div class="mb-3">
                                <label for="kontributor_2" class="form-label">Kontributor 2</label>
                                <input type="text" class="form-control" id="kontributor_2" name="kontributor_2">
                            </div>
                            <div class="mb-4">
                                <label for="kontributor_3" class="form-label">Kontributor 3</label>
                                <input type="text" class="form-control" id="kontributor_3" name="kontributor_3">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="mahasiswa1" class="form-label">NIM Mahasiswa 1</label>
                                <input type="number" class="form-control" id="mahasiswa1" name="mahasiswa1" required>
                            </div>
                            <div class="mb-3">
                                <label for="mahasiswa2" class="form-label">NIM Mahasiswa 2</label>
                                <input type="number" class="form-control" id="mahasiswa2" name="mahasiswa2">
                            </div>
                            <div class="mb-3">
                                <label for="mahasiswa3" class="form-label">NIM Mahasiswa 3</label>
                                <input type="number" class="form-control" id="mahasiswa3" name="mahasiswa3">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mb-3">
                                <label for="dokumen_1" class="form-label">Dokumen 1</label>
                                <input class="form-control" type="file" id="dokumen_1" name="dokumen_1" accept=".pdf"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_2" class="form-label">Dokumen 2</label>
                                <input class="form-control" type="file" id="dokumen_2" name="dokumen_2" accept=".pdf"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_3" class="form-label">Dokumen 3</label>
                                <input class="form-control" type="file" id="dokumen_3" name="dokumen_3" accept=".pdf"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_4" class="form-label">Dokumen 4</label>
                                <input class="form-control" type="file" id="dokumen_4" name="dokumen_4"
                                    accept=".pdf" required>
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_opsional_1" class="form-label">Dokumen Opsional 1</label>
                                <input class="form-control" type="file" id="dokumen_opsional_1"
                                    name="dokumen_opsional_1" accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label for="dokumen_opsional_2" class="form-label">Dokumen Opsional 2</label>
                                <input class="form-control" type="file" id="dokumen_opsional_2"
                                    name="dokumen_opsional_2" accept=".pdf">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.tugas-akhir.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
