@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h3>Data Tugas Akhir</h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="{{ route('admin.tugas-akhir.create') }}" class="btn btn-primary">Tambah Data Tugas Akhir</a>
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
                @if (count($tugas_akhir) == 0)
                    <div class="alert alert-dark">
                        Tidak ada data.
                    </div>
                @else
                    <table class="table table-striped table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul</th>
                                <th>Tahun</th>
                                <th>Kata Kunci</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tugas_akhir as $tugas)
                                <tr>
                                    <td>{{ $tugas->id }}</td>
                                    <td>{{ $tugas->judul }}</td>
                                    <td>{{ $tugas->tahun }}</td>
                                    <td>{{ $tugas->kata_kunci }}</td>
                                    <td>
                                        <a href="{{ route('admin.tugas-akhir.show', $tugas->id) }}"
                                            class="btn btn-info">Detail</a>
                                        <form action="{{ route('admin.tugas-akhir.destroy', $tugas->id) }}" method="post"
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
