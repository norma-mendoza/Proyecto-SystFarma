<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item text-center"><span>Menú</span></li>
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="fas fa-chart-pie"></i> Dashboard</a>
            </li>
            {{-- <li class="nav-title">
                Mantenimiento
            </li> --}}
            
            
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-receipt"></i> Ventas</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Ventas</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Clientes</a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-chart-area"></i> Reportes</a>
                <ul class="nav-dropdown-items">
                    
                    <li @click="menu=13" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ventas</a>
                    </li>
                </ul>
            </li>
            <li @click="menu=14" class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-book"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>