@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h3>Data Program Studi</h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="{{ route('admin.program-studi.create') }}" class="btn btn-primary">Tambah Data Program Studi</a>
                <a href="{{ route('admin.program-studi.import') }}" class="btn btn-success">Import Data Program Studi
                    (Excel)</a>
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
                @if (count($program_studi) == 0)
                    <div class="alert alert-dark">
                        Tidak ada data.
                    </div>
                @else
                    <table class="table table-striped table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Jurusan</th>
                                <th>Diploma</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($program_studi as $pd)
                                <tr>
                                    <td>{{ $pd->nomor }}</td>
                                    <td>{{ $pd->nama }}</td>
                                    <td>{{ $pd->kode }}</td>
                                    <td>{{ $pd->jurusan }}</td>
                                    <td>{{ $pd->diploma }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.program-studi.edit', $pd->nomor) }}"
                                            class="btn btn-warning">Ubah</a>
                                        <form action="{{ route('admin.program-studi.destroy', $pd->nomor) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger delete">Hapus</button>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin menghapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#3085d6',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent().submit();
                    }
                })
            });
        });
    </script>
@endpush
