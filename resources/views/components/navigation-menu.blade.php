<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="{{ route('panel') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Panel de administración
                </a>
                <!--  
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layouts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Static Navigation</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.html">Login</a>
                                <a class="nav-link" href="register.html">Register</a>
                                <a class="nav-link" href="password.html">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div>-->
                <div class="sb-sidenav-menu-heading">Módulos</div>
                @can('ver-venta')
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVentas" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                        Ventas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseVentas" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('ventas.index')}}">Ver</a>
                            <a class="nav-link" href="{{ route('ventas.create')}}">Crear</a>
                        </nav>
                    </div>
                @endcan
                
                @can('ver-compra')
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                            Compras
                         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('compras.index')}}">Ver</a>
                            <a class="nav-link" href="{{ route('compras.create')}}">Crear</a>
                        </nav>
                    </div>
                @endcan

                <a class="nav-link" href="{{ route('actualizar.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                    Actualizar precios
                </a>
                
                @can('ver-categoria')
                    <a class="nav-link" href="{{ route('categorias.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-tag"></i></div>
                        Categorias
                    </a>
                @endcan

                @can('ver-producto')
                    <a class="nav-link" href="{{ route('productos.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-brands fa-product-hunt"></i></div>
                        Productos
                    </a>
                @endcan
                
                @can('ver-persona')
                    <a class="nav-link" href="{{ route('personas.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-people-group"></i></div>
                        Clientes
                    </a>
                @endcan
                
                @can('ver-proveedor')
                    <a class="nav-link" href="{{ route('proveedores.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-person-walking-arrow-right"></i></div>
                        Proveedores
                    </a>
                @endcan
                
                <div class="sb-sidenav-menu-heading">OTROS</div>

                @can('ver-user')
                    <a class="nav-link" href="{{ route('usuarios.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                        Usuarios
                    </a>
                @endcan

                @can('ver-role')
                    <a class="nav-link" href="{{ route('roles.index')}}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-person-circle-plus"></i></div>
                        Roles
                    </a>
                @endcan

                
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>