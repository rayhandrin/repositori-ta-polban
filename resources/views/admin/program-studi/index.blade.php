@extends('layouts.app')

@section('content')
    <div class="container-lg mb-5">
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
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover table-responsive']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/scripts.js') }}"></script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
