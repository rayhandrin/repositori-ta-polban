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
                <form action="{{ route('admin.program-studi.store') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor<span class="text-danger ms-1">*</span></label>
                        <input type="number" class="form-control @error('nomor') is-invalid @enderror" id="nomor"
                            name="nomor" value="{{ old('nomor') }}" autofocus>
                        @error('nomor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode"
                            name="kode" value="{{ old('kode') }}">
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan"
                            name="jurusan" value="{{ old('jurusan') }}">
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="diploma" class="form-label">Diploma<span class="text-danger ms-1">*</span></label>
                        <input type="text" class="form-control @error('diploma') is-invalid @enderror" id="diploma"
                            name="diploma" value="{{ old('diploma') }}">
                        @error('diploma')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
