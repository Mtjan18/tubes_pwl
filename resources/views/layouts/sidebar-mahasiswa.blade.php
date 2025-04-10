<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.mahasiswa') }}">
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
                    <li class="nav-item"> <a class="nav-link" href="{{ route('Mahasiswa.FormSurat') }}">Form</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('surat.detail')}}">Status</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Surat</a></li>
                </ul>
            </div>
    </ul>
</nav>
