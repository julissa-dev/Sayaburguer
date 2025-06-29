<header class="navbar">
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/front/log.png') }}" alt="Logo del sitio" />
        </a>
    </div>

    <div class="acciones">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="searchInput" placeholder="¿Qué necesitas?" autocomplete="off" />
        <div id="searchResults" class="search-results-dropdown">
            {{-- Los resultados de la búsqueda se inyectarán aquí --}}
        </div>
    </div>

    <button class="menu-toggle" aria-label="Abrir menú">
        <i class="fa-solid fa-bars"></i>
    </button>

    <nav class="nav-links">
        <a href="{{ route('menu') }}" class="{{ Request::routeIs('menu') ? 'active-link' : '' }}">
            <i class="fa-solid fa-burger"></i> MENU
        </a>
        <a href="{{ route('promociones') }}" class="{{ Request::routeIs('promociones') ? 'active-link' : '' }}"><i
                class="fa-solid fa-percent"></i> PROMOCIONES</a>
        {{-- INICIO: Dropdown de Delivery a Domicilio --}}
        <div class="dropdown">
            <a href="#" id="deliveryToggle" class="dropdown-toggle">
                <i class="fas fa-bicycle"></i> Delivery a domicilio <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <div class="dropdown-menu" id="deliveryDropdownMenu">
                <div class="delivery-modal-content">
                    <div class="delivery-dropdown-header">
                        <h3>Información de Envío</h3>
                        <button class="close-delivery-btn" id="closeDeliveryBtn" type="button">&times;</button>
                    </div>
                    <div class="delivery-dropdown-content">
                        @auth
                            <p class="user-delivery-address">
                                @if (Auth::user()->direccion)
                                    <i class="fas fa-map-marker-alt"></i> Tu dirección actual: <br>
                                    <strong id="currentDeliveryAddress">{{ Auth::user()->direccion }}</strong>
                                @else
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span id="currentDeliveryAddress">No tienes una dirección registrada.</span>
                                @endif
                            </p>
                            <button class="btn-manage-address" id="manageAddressBtn">
                                @if (Auth::user()->direccion)
                                    Cambiar Dirección
                                @else
                                    Agregar Dirección
                                @endif
                            </button>
                        @endauth
                        @guest
                            <p class="no-address">
                                <i class="fas fa-info-circle"></i> Inicia sesión para gestionar tu dirección de envío.
                            </p>
                            <button class="btn-manage-address" id="btnLoginBtn">
                                Iniciar Sesión
                            </button>
                        @endguest

                        <hr>

                        <div class="delivery-info-section">
                            <h4>Detalles del Envío en Trujillo</h4>
                            <ul class="delivery-list">
                                <li><i class="fas fa-money-bill-wave"></i> <b>Costo de Envío:</b> <span class="delivery-price">S/ 7.00</span></li>
                                <li><i class="fas fa-clock"></i> <b>Horario:</b> Lunes a Domingo: 6:00 PM - 1:00 AM</li>
                                <li><i class="fas fa-motorcycle"></i> <b>Tiempo Estimado:</b> 30 - 45 min (puede variar)</li>
                                <li><i class="fas fa-dollar-sign"></i> Cancelar antes del envío</li>
                            </ul>
                            <p class="small-text">
                                <i class="fas fa-exclamation-triangle"></i> Zonas de Cobertura: Todo Trujillo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- FIN: Dropdown de Delivery a Domicilio --}}

        @auth
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" id="userDropdownToggle">
                <i class="fa-solid fa-user"></i> {{ Auth::user()->nombre }} <i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <div class="dropdown-menu" id="userDropdownMenu">
                <div class="user-modal-content">
                    <div class="dropdown-header">
                        <h3>Mi Perfil</h3>
                        <button class="close-user-btn" id="closeUserBtn" type="button">&times;</button>
                    </div>
                    <div class="dropdown-content">
                        <ul class="user-list">
                            <li><a href="{{ route('perfil') }}"><i class="fa-solid fa-user"></i> Perfil</a></li>
                            <li><a href="{{ route('perfil.misPedidos') }}"><i class="fa-solid fa-list"></i> Mis Pedidos</a></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin:0;">
                                    @csrf
                                    <button type="submit" style="width:100%;text-align:left;background:none;border:none;padding:0.6rem 0;color:#c00000;">
                                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
            <button class="cart" id="cartButton">
                <i class="fa-solid fa-cart-shopping"></i><span class="cart-count">{{ $contador }}</span>
            </button>

            <div class="cart-dropdown" id="cartDropdown">
                <div class="cart-dropdown-header">
                    <h3>Tu Carrito</h3>
                    <button class="close-cart-btn" id="closeCartBtn">&times;</button>
                </div>
                <div class="cart-dropdown-items" id="cartDropdownItems">
                    {{-- Aquí se incluirá el contenido de los ítems del carrito. --}}
                    @include('partials.cart_items', [
                        'carritoItems' => $carritoItems,
                        'promocionItems' => $promocionItems,
                    ])
                </div>
                <div class="cart-dropdown-footer">
                    <span class="total-label">Total:</span>
                    <span class="total-price" id="cartTotalPrice">S/{{ number_format($totalPrice ?? 0, 2) }}</span>
                    <button class="btn-checkout" id="btnIrAPagar">Ir a Pagar</button>

                    <form id="formIrAPagar" action="{{ route('checkout.iniciar') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
            </div>
        @endauth
        @guest {{-- Si el usuario NO está autenticado (es un invitado) --}}
            <a href="{{ route('login') }}"><i class="fa-solid fa-user"></i> INGRESAR</a>
            <button class="cart"><i class="fa-solid fa-cart-shopping"></i><span class="cart-count">0</span></button>
        @endguest
    </nav>
</header>

<script>
    document.getElementById('btnIrAPagar').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Deseas continuar con tu pedido?',
            text: "Serás dirigido a la pantalla de confirmación de pago.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formIrAPagar').submit();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para el cierre de sesión
        document.getElementById('logout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Evita que el click dentro del modal-content cierre el modal
        document.querySelectorAll('.delivery-modal-content, .user-modal-content').forEach(function(modal) {
            modal.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
