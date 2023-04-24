@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h3>Import Data Program Studi</h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="{{ route('admin.program-studi.index') }}" class="btn btn-dark">Kembali</a>
                <a href="{{ route('admin.program-studi.template') }}" class="btn btn-primary">Download Template</a>
                @if (session()->get('message'))
                    <div class="alert alert-success mt-4 mb-0 alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session()->get('failures'))
                    <div class="alert alert-danger mt-5 mb-0 alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach (session()->get('failures') as $failure)
                                @foreach ($failure->errors() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-6">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="formFile" class="form-label">Upload File Template</label>
                    <input class="form-control" type="file" name="excel" id="formFile">
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
