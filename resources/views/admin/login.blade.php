@extends('layouts.app')

@section('content')
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-4">
                    @if ($errors->has('message'))
                        <div class="alert alert-danger mt-4 mb-3 alert-dismissible fade show" role="alert">
                            {{ $errors->first('message') }}
                            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif(session()->get('message'))
                        <div class="alert alert-success mt-4 mb-3 alert-dismissible fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="btn-close" data-coreui-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card p-4 mb-0">
                        <div class="card-body">
                            <h1 class="mb-4 text-center">Login</h1>
                            <form action="" method="post" autocomplete="off" novalidate>
                                @csrf
                                <div class="input-group has-validation mb-4">
                                    <span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                        </svg>
                                    </span>
                                    <input class="form-control @error('username') is-invalid @enderror" type="text"
                                        placeholder="Username" name="username" autofocus>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-group has-validation mb-4">
                                    <span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                                        </svg>
                                    </span>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        placeholder="Password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-primary px-4" type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
