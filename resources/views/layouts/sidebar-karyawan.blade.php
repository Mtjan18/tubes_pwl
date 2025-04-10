<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Pengajuan Surat</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('karyawan.daftarSurat') }}">Daftar Surat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Riwayat Surat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Detail Surat</a></li>
                </ul>
            </div>
    </ul>
</nav>
