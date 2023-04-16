@extends('layouts.app')

@section('content')
    <div class="container-lg mb-5">
        <div class="row">
            <div class="col">
                <h3>Tambah Data Program Studi</h3>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-4">
                <form action="{{ route('admin.program-studi.store') }}" method="post" autocomplete="on">
                    @csrf
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor</label>
                        <input type="number" class="form-control" id="nomor" name="nomor" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" required>
                    </div>
                    <div class="mb-4">
                        <label for="diploma" class="form-label">Diploma</label>
                        <input type="text" class="form-control" id="diploma" name="diploma" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.program-studi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
