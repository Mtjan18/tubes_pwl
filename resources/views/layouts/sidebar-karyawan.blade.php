<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.byProdi', 'TI') }}">
                <i class="mdi mdi-file-document-box"></i>
                <span class="menu-title">Prodi TI</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.byProdi', 'SI') }}">
                <i class="mdi mdi-file-document-box"></i>
                <span class="menu-title">Prodi SI</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('karyawan.byProdi', 'MI') }}">
                <i class="mdi mdi-file-document-box"></i>
                <span class="menu-title">Prodi MI</span>
            </a>
        </li>
        
        
    </ul>
</nav>
