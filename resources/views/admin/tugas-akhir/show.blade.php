@extends('layouts.app')

@section('content')
    <div class="container-lg mb-5">
        <div class="row">
            <div class="col">
                <h3>Detail Tugas Akhir</h3>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-10">
                <div class="row gx-5">
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" value="{{ $tugas_akhir->id }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" value="{{ $tugas_akhir->judul }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="tahun" value="{{ $tugas_akhir->tahun }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kata_kunci" class="form-label">Kata Kunci</label>
                            <input type="text" class="form-control" id="kata_kunci"
                                value="{{ $tugas_akhir->kata_kunci }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="kontributor" class="form-label">Kontributor</label>
                            <ul class="list-group">
                                @if ($tugas_akhir->kontributor_1 != null)
                                    <li class="list-group-item">{{ $tugas_akhir->kontributor_1 }}</li>
                                @endif
                                @if ($tugas_akhir->kontributor_2 != null)
                                    <li class="list-group-item">{{ $tugas_akhir->kontributor_2 }}</li>
                                @endif
                                @if ($tugas_akhir->kontributor_3 != null)
                                    <li class="list-group-item">{{ $tugas_akhir->kontributor_3 }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="mb-3">
                            <label for="created_at" class="form-label">Ditambahkan pada</label>
                            <input type="text" class="form-control" id="created_at"
                                value="{{ $tugas_akhir->created_at ? $tugas_akhir->created_at->format('d F Y - H:i:s') : '' }}"
                                readonly>
                        </div>
                        <div class="mb-4">
                            <label for="updated_at" class="form-label">Diperbarui pada</label>
                            <input type="text" class="form-control" id="updated_at"
                                value="{{ $tugas_akhir->created_at ? $tugas_akhir->updated_at->format('d F Y - H:i:s') : '' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Mahasiswa</label>
                        <ul class="list-group">
                            @foreach ($tugas_akhir->mahasiswa as $mahasiswa)
                                <li class="list-group-item">{{ $mahasiswa->nim . ' - ' . $mahasiswa->nama }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Dokumen</label>
                        @foreach ($tugas_akhir->filepath as $key => $path)
                            <a href="{{ route('admin.tugas-akhir.access', $path) }}"
                                class="btn btn-outline-primary d-block mb-2 w-50"
                                target="_blank">{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}</a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.tugas-akhir.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
