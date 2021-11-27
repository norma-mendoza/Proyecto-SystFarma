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
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-warehouse"></i> Almacén</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i>
                            Categorías</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i> Productos</a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i> Presentacion</a>
                    </li>
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-arrow-right"></i> Laboratorio</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-shopping-cart"></i> Compras</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Ingresos</a>
                    </li>
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-notebook"></i> Proveedores</a>
                    </li>
                </ul>
            </li>
            
            
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-chart-area"></i> Reportes</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=12" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ingresos</a>
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