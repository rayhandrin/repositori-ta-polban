@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h3>Data Mahasiswa</h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">Tambah Data Mahasiswa</a>
                @if (session()->get('message'))
                    <div class="alert alert-success mt-4 mb-0 alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                @if (count($mahasiswa) == 0)
                    <div class="alert alert-dark">
                        Tidak ada data.
                    </div>
                @else
                    <table class="table table-striped table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Status Aktif</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $mhs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mhs->nim }}</td>
                                    <td>{{ $mhs->nama }}</td>
                                    <td>{{ $mhs->program_studi }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill {{ $mhs->status_aktif ? 'text-bg-success' : 'text-bg-warning' }}">
                                            {{ $mhs->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.mahasiswa.show', $mhs->nim) }}"
                                            class="btn btn-info">Detail</a>
                                        <form action="{{ route('admin.mahasiswa.destroy', $mhs->nim) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
