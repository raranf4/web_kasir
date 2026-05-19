<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetBakery - Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfaf7; margin: 0; overflow-x: hidden; }
        .wrapper { display: flex; min-height: 100vh; width: 100vw; position: relative; }
        .sidebar { width: 260px; background-color: #2d1b10; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; position: fixed; top: 0; bottom: 0; left: 0; height: 100vh; z-index: 100; }
        .main-content { flex-grow: 1; padding: 40px 50px; margin-left: 260px; width: calc(100vw - 260px); min-height: 100vh; background-color: #fcfaf7; }
        .sidebar-brand { display: flex; align-items: center; gap: 10px; color: white; text-decoration: none; padding-left: 8px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a { color: #ebdcd0; display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; margin-bottom: 8px; transition: all 0.2s; }
        .sidebar-menu li:hover a, .sidebar-menu li.active a { background-color: #d4a373; color: white; }
        .profile-minimal-box { display: flex; align-items: center; gap: 12px; padding: 12px; background: rgba(255,255,255,0.04); border-radius: 14px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 15px; }
        .profile-avatar-circle { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #d4a373; }
        .btn-keluar-sistem { color: #ffb3b3; display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; background: rgba(220, 53, 69, 0.1); transition: all 0.2s; border: none; width: 100%; text-align: left; cursor: pointer; }
        .btn-keluar-sistem:hover { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <div>
            <a href="/dashboard" class="sidebar-brand mb-4">
                <span class="material-icons-round" style="color: #d4a373;">bakery_dining</span>
                <h5 class="fw-bold m-0" style="letter-spacing: 0.5px;">SWEET BAKERY</h5>
            </a>

            <ul class="sidebar-menu">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="/dashboard"><span class="material-icons-round">dashboard</span> Dashboard</a>
                </li>
                @if(Auth::check() && Auth::user()->role && Auth::user()->role->nama_role == 'admin')
                    <li class="{{ Request::is('admin/produk*') ? 'active' : '' }}">
                        <a href="{{ route('admin.produk.index') }}"><span class="material-icons-round">cake</span> Data Produk</a>
                    </li>
                    <li class="{{ Request::is('admin/kategori*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kategori.index') }}"><span class="material-icons-round">category</span> Kelola Kategori</a>
                    </li>
                @endif
                <li class="{{ Request::is('user/produk*') ? 'active' : '' }}">
                    <a href="{{ route('user.produk.index') }}"><span class="material-icons-round">local_mall</span> Katalog Etalase</a>
                </li>
            </ul>
        </div>

        <div class="sidebar-bottom-group">
            <div class="profile-minimal-box">
                @if(Auth::check())
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=d4a373&color=fff&bold=true" class="profile-avatar-circle" alt="User">
                    <div>
                        <h6 class="text-white m-0 small fw-bold text-truncate" style="max-width: 140px;">{{ Auth::user()->name }}</h6>
                        <small style="color: #c4c4c4; font-size: 11px;">
                            {{ (Auth::user()->role && Auth::user()->role->nama_role == 'admin') ? 'Owner Toko' : 'Staf Kasir' }}
                        </small>
                    </div>
                @endif
            </div>

            <button class="btn-keluar-sistem" onclick="confirmLogout()">
                <span class="material-icons-round">logout</span> Keluar Sistem
            </button>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Fungsi Popup Konfirmasi Keluar Sistem
function confirmLogout() {
    Swal.fire({
        title: 'Keluar aplikasi?',
        text: "Sesi kerja Anda di mesin kasir Sweet Bakery akan diakhiri.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}

// Global script untuk menangani tombol dengan class 'btn-delete' menggunakan SweetAlert2
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        let targetButton = e.target.closest('.btn-delete');
        if (targetButton) {
            e.preventDefault();
            let form = targetButton.closest('form');
            Swal.fire({
                title: 'Hapus data?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
});
</script>

</body>
</html>