<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-menu') }}"></use>
            </svg>
        </button>
        <a class="header-brand d-md-none me-0" href="#">
            {{-- <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
            </svg> --}}
            ReTA
        </a>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    {{-- <div class="avatar avatar-md me-3">
                        <img class="avatar-img" src="{{ asset('assets/img/avatars/8.jpg') }}" alt="user@email.com">
                    </div> --}}
                    @if (auth()->check())
                        {{ auth()->user()->nama }}
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Akun</div>
                    </div>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                        </svg> Profil
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('admin.logout') }}" method="post">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <svg class="icon me-2">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-account-logout') }}">
                                </use>
                            </svg> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    {{-- <div class="header-divider"></div> --}}
    {{-- <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                <li class="breadcrumb-item">
                    <!-- if breadcrumb is single--><span>Home</span>
                </li>
                <li class="breadcrumb-item active"><span>Blank</span></li>
            </ol>
        </nav>
    </div> --}}
</header>
