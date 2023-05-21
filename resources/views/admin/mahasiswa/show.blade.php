@extends('layouts.app')

@section('content')
    <div class="container-lg mb-5">
        <div class="row">
            <div class="col">
                <h3>Detail Mahasiswa</h3>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-4">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="number" class="form-control" id="nim" value="{{ $mahasiswa->nim }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" value="{{ $mahasiswa->nama }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" id="program_studi"
                        value="{{ $mahasiswa->programStudi->nama }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $mahasiswa->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="email_verified_at" class="form-label">Verifikasi Email</label>
                    <input type="email_verified_at" class="form-control" id="email_verified_at"
                        value="{{ $mahasiswa->email_verified_at ? $mahasiswa->email_verified_at->format('d F Y - H:i:s') : '' }}"
                        readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="status_aktif">Status Aktif</label>
                    <span class="badge rounded-pill {{ $mahasiswa->status_aktif ? 'text-bg-success' : 'text-bg-warning' }}">
                        {{ $mahasiswa->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                <div class="mb-3">
                    <label for="created_at" class="form-label">Ditambahkan pada</label>
                    <input type="text" class="form-control" id="created_at"
                        value="{{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d F Y - H:i:s') : '' }}"
                        readonly>
                </div>
                <div class="mb-4">
                    <label for="updated_at" class="form-label">Diperbarui pada</label>
                    <input type="text" class="form-control" id="updated_at"
                        value="{{ $mahasiswa->updated_at ? $mahasiswa->updated_at->format('d F Y - H:i:s') : '' }}"
                        readonly>
                </div>
                <div>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
