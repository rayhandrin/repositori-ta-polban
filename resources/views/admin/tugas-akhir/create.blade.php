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
                                <label for="judul" class="form-label">Judul<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" autofocus>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                    id="tahun" name="tahun">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="kata_kunci" class="form-label">Kata Kunci</label>
                                <input type="text" class="form-control @error('kata_kunci') is-invalid @enderror"
                                    id="kata_kunci" name="kata_kunci">
                                @error('kata_kunci')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="kontributor_1" class="form-label">Kontributor 1</label>
                                <input type="text" class="form-control @error('kontributor_1') is-invalid @enderror"
                                    id="kontributor_1" name="kontributor_1">
                                @error('kontributor_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="kontributor_2" class="form-label">Kontributor 2</label>
                                <input type="text" class="form-control @error('kontributor_2') is-invalid @enderror"
                                    id="kontributor_2" name="kontributor_2">
                                @error('kontributor_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="kontributor_3" class="form-label">Kontributor 3</label>
                                <input type="text" class="form-control @error('kontributor_3') is-invalid @enderror"
                                    id="kontributor_3" name="kontributor_3">
                                @error('kontributor_3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="mahasiswa_1" class="form-label">NIM Mahasiswa 1<span
                                        class="text-danger ms-1">*</span></label>
                                <input type="number" class="form-control @error('mahasiswa_1') is-invalid @enderror"
                                    id="mahasiswa_1" name="mahasiswa_1">
                                @error('mahasiswa_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="mahasiswa_2" class="form-label">NIM Mahasiswa 2</label>
                                <input type="number" class="form-control @error('mahasiswa_2') is-invalid @enderror"
                                    id="mahasiswa_2" name="mahasiswa_2">
                                @error('mahasiswa_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="mahasiswa_3" class="form-label">NIM Mahasiswa 3</label>
                                <input type="number" class="form-control @error('mahasiswa_3') is-invalid @enderror"
                                    id="mahasiswa_3" name="mahasiswa_3">
                                @error('mahasiswa_3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mb-3">
                                <label for="cover" class="form-label">Cover<span
                                        class="text-danger ms-1">*</span></label>
                                <input class="form-control @error('cover') is-invalid @enderror" type="file"
                                    id="cover" name="cover" accept=".pdf">
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bab_1" class="form-label">BAB I<span
                                        class="text-danger ms-1">*</span></label>
                                <input class="form-control @error('bab_1') is-invalid @enderror" type="file"
                                    id="bab_1" name="bab_1" accept=".pdf">
                                @error('bab_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bab_2" class="form-label">BAB II<span
                                        class="text-danger ms-1">*</span></label>
                                <input class="form-control @error('bab_2') is-invalid @enderror" type="file"
                                    id="bab_2" name="bab_2" accept=".pdf">
                                @error('bab_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bab_5" class="form-label">BAB V<span
                                        class="text-danger ms-1">*</span></label>
                                <input class="form-control @error('bab_5') is-invalid @enderror" type="file"
                                    id="bab_5" name="bab_5" accept=".pdf">
                                @error('bab_5')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="kelengkapan" class="form-label">Kelengkapan<span
                                        class="text-danger ms-1">*</span></label>
                                <input class="form-control @error('kelengkapan') is-invalid @enderror" type="file"
                                    id="kelengkapan" name="kelengkapan" accept=".pdf">
                                @error('kelengkapan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bab_3" class="form-label">BAB III</label>
                                <input class="form-control @error('bab_3') is-invalid @enderror" type="file"
                                    id="bab_3" name="bab_3" accept=".pdf">
                                @error('bab_3')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bab_4" class="form-label">BAB IV</label>
                                <input class="form-control @error('bab_4') is-invalid @enderror" type="file"
                                    id="bab_4" name="bab_4" accept=".pdf">
                                @error('bab_4')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="opsional_1" class="form-label">Opsional 1</label>
                                <input class="form-control @error('opsional_1') is-invalid @enderror" type="file"
                                    id="opsional_1" name="opsional_1" accept=".pdf">
                                @error('opsional_1')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="opsional_2" class="form-label">Opsional 2</label>
                                <input class="form-control @error('opsional_2') is-invalid @enderror" type="file"
                                    id="opsional_2" name="opsional_2" accept=".pdf">
                                @error('opsional_2')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
