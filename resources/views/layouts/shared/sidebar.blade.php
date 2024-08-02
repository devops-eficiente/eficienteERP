<div class="app-menu">
    @php
        auth()->user()->company;
    @endphp
    <!-- Sidenav Brand Logo -->
    <a href="#" class="logo-box">
        <!-- Light Brand Logo -->
        <div class="logo-light">
            <img src="/{{ asset('eficiente/logos/logo.png') }}" class="logo-lg h-6" alt="Light logo">
            <img src="{{ asset('eficiente/logos/iconlogo.png') }}" class="logo-sm rounded-xl" alt="Small logo">
        </div>

        <!-- Dark Brand Logo -->
        <div class="logo-dark">
            <img src="{{ asset('eficiente/logos/logo.png') }}" class="logo-lg h-6" alt="Dark logo">
            <img src="{{ asset('eficiente/logos/iconlogo.png') }}" class="logo-sm rounded-xl" alt="Small logo">
        </div>
    </a>

    <!-- Sidenav Menu Toggle Button -->
    <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
        <span class="sr-only">Menu Toggle Button</span>
        <i class="mgc_round_line text-xl"></i>
    </button>

    <!--- Menu -->
    <div class="srcollbar" data-simplebar>
        <ul class="menu" data-fc-type="accordion">
            <li class="menu-title">Inicio</li>

            <li class="menu-item">
                <a href="{{ route('index') }}" class="menu-link">
                    <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
                    <span class="menu-text"> Dashboard</span>
                </a>
            </li>
            @if (auth()->user()->hasRole(['admin_empresa', 'usuario_empresa']) and auth()->user()->company->modules->contains(1))
                <li class="menu-item">
                    <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                        <span class="menu-icon"><i class="mgc_user_5_fill"></i></span>
                        <span class="menu-text"> Empleados </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="sub-menu hidden">
                        <li class="menu-item">
                            <a href="{{ route('admin.create_employee') }}" class="menu-link">
                                <span class="menu-text">Crear Empleado</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('admin.employees') }}" class="menu-link">
                                <span class="menu-text">Ver plantilla</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasRole(['admin_empresa', 'usuario_empresa']) and auth()->user()->company->modules->contains(2))
                <li class="menu-item">
                    <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                        <span class="menu-icon"><i class="mgc_group_fill"></i></span>
                        <span class="menu-text"> Clientes </span>
                        <span class="menu-arrow"></span>
                    </a>

                    <ul class="sub-menu hidden">
                        <li class="menu-item">
                            <a href="{{ route('admin.create_client') }}" class="menu-link">
                                <span class="menu-text">Crear cliente</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('admin.clients') }}" class="menu-link">
                                <span class="menu-text">Ver plantilla</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasRole(['admin_empresa', 'usuario_empresa']) and auth()->user()->company->modules->contains(3))
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon"><i class="mgc_coin_fill"></i></span>
                        <span class="menu-text"> Finanzas </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasRole(['admin_empresa', 'usuario_empresa']) and auth()->user()->company->modules->contains(4))
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon"><i class="mgc_chart_line_fill"></i></span>
                        <span class="menu-text"> Contabilidad </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasRole(['admin_empresa', 'usuario_empresa']) and auth()->user()->company->modules->contains(5))
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon"><i class="mgc_chart_bar_line"></i></span>
                        <span class="menu-text"> Reportes </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasRole(['admin_empresa', 'usuario_empresa']) and auth()->user()->company->modules->contains(6))
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon"><i class="mgc_wallet_4_fill"></i></span>
                        <span class="menu-text"> Nominas </span>
                    </a>
                </li>
            @endif
            @role('super_admin')
                <li class="menu-title">Administrador</li>
                <li class="menu-item">
                    <a href="{{ route('admin.webservice') }}" class="menu-link">
                        <span class="menu-icon"><i class="mgc_world_fill"></i></span>
                        <span class="menu-text"> WebService </span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.company.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="mgc_building_1_fill"></i></span>
                        <span class="menu-text"> Empresas </span>
                    </a>
                </li>
            @endrole
            @role('admin_empresa')
                <li class="menu-title">Administrador</li>
                <li class="menu-item">
                    <a href="{{ route('admin.user.index') }}" class="menu-link">
                        <span class="menu-icon"><i class="mgc_user_3_fill"></i></span>
                        <span class="menu-text"> Usuarios </span>
                    </a>
                </li>
            @endrole
        </ul>
    </div>
</div>
<!-- Sidenav Menu End  -->
