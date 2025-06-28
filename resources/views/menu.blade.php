<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Saya Burguer</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}" />
    <script src="https://kit.fontawesome.com/a2d4f54cbc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    {{-- Incluye la plantilla del header --}}
    @include('partials.header', [
        'contador' => $contador ?? 0,
        'carritoItems' => $carritoItems ?? collect(),
        'promocionItems' => $promocionItems ?? collect(), // <--- Agrega esta línea
        'totalPrice' => $totalPrice ?? 0,
    ])


    <section class="categorias-menu">
        {{-- Botón "Ver todo" siempre al inicio --}}
        <button class="categoria-item active" data-categoria-id="all">
            <div class="circle-texto">Ver todo</div>
            <span>Ver todo</span>
        </button>

        {{-- Iterar por las categorías --}}
        @foreach ($categorias as $categoria)
            <button class="categoria-item" data-categoria-id="{{ $categoria->id }}">
                @if ($categoria->imagen_icono)
                    <img src="{{ asset('storage/img/categorias/' . $categoria->imagen_icono) }}"
                        alt="Icono de {{ $categoria->nombre }}">
                @else
                    <img src="{{ asset('img/categoria/default.png') }}"
                        alt="Icono por defecto de {{ $categoria->nombre }}">
                @endif
                <span>{{ $categoria->nombre }}</span>
            </button>
        @endforeach
    </section>

    <main class="catalogo">
        <aside class="filtros">
            <h3>Filtrar por:</h3>
            <p><strong>Precios:</strong></p>
            <label><input type="checkbox" class="price-filter-checkbox" data-min-price="0" data-max-price="20" /> Hasta
                S/20</label>
            <label><input type="checkbox" class="price-filter-checkbox" data-min-price="21" data-max-price="30" /> S/21
                - S/30</label>
            <label><input type="checkbox" class="price-filter-checkbox" data-min-price="31" data-max-price="50" /> S/31
                - S/50</label>
            <label><input type="checkbox" class="price-filter-checkbox" data-min-price="51" data-max-price="9999" />
                S/51 +</label>
        </aside>

        <section class="productos">
            <h2>NUESTRA CARTA</h2>
            <div class="grid-productos">
                {{-- Los productos se cargarán aquí vía AJAX --}}
            </div>

            <div class="paginacion">
                {{-- La paginación se cargará aquí vía AJAX --}}
            </div>
        </section>
    </main>



    {{-- Tu JavaScript puede quedarse en el archivo principal si es específico de la página,
         o moverlo a un archivo .js externo si es global. --}}
    <script>
        window.routes = {
            productosFiltrar: "{{ route('productos.filtrar') }}",
            perfil: "{{ route('perfil') }}",
            login: "{{ route('login') }}"
            // Añade aquí cualquier otra ruta que necesites en tus JS
        };
    </script>

    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/products.js') }}"></script>

   <footer style="background: #FFD600; font-family: 'Montserrat', Arial, sans-serif; color: #222; font-size: 15px; margin-top: 48px;">
  <div style="max-width: 1200px; margin: 0 auto; padding: 48px 32px; display: flex; flex-wrap: wrap; gap: 50px; justify-content: space-between;">

    <!-- Contacto -->
    <div style="flex: 1 1 250px; min-width: 220px;">
      <h4 style="font-weight: 700; font-size: 1.2em; margin-bottom: 16px;">
        <i class="fas fa-headset" style="margin-right: 8px;"></i>Contacto
      </h4>
      <p style="margin: 8px 0;">
        <i class="fas fa-phone-alt" style="margin-right: 8px;"></i> (01) 505 0000
      </p>
      <p style="margin: 8px 0;">
        <i class="fas fa-envelope" style="margin-right: 8px;"></i> contacto@sayaburger.com
      </p>
      <p style="margin: 8px 0;">
        <i class="fas fa-clock" style="margin-right: 8px;"></i> 12:00 p.m. - 11:00 p.m.
      </p>
      <h4 style="font-weight: 700; font-size: 1.2em; margin: 24px 0 12px;">
        <i class="fas fa-share-alt" style="margin-right: 8px;"></i>Síguenos
      </h4>
      <div style="display: flex; gap: 16px;">
        <a href="#" style="color: #222; text-decoration: none;"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" style="color: #222; text-decoration: none;"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="#" style="color: #222; text-decoration: none;"><i class="fab fa-tiktok fa-lg"></i></a>
      </div>
    </div>

    <!-- Enlaces -->
    <div style="flex: 1 1 200px; min-width: 180px;">
      <h4 style="font-weight: 700; font-size: 1.2em; margin-bottom: 16px;">
        <i class="fas fa-link" style="margin-right: 8px;"></i>Enlaces
      </h4>
      <nav style="display: flex; flex-direction: column; gap: 10px;">
        <a href="{{ route('home') }}" style="color: #222; text-decoration: none;">Inicio</a>
        <a href="{{ route('menu') }}" style="color: #222; text-decoration: none;">Menú</a>
        <a href="{{ route('promociones') }}" style="color: #222; text-decoration: none;">Promociones</a>
        <a href="{{ route('perfil') }}" style="color: #222; text-decoration: none;">Perfil</a>
        <a href="#" style="color: #222; text-decoration: none;">Ubícanos</a>
      </nav>
    </div>

    <!-- Sobre Nosotros -->
    <div style="flex: 1 1 250px; min-width: 220px;">
      <h4 style="font-weight: 700; font-size: 1.2em; margin-bottom: 16px;">
        <i class="fas fa-info-circle" style="margin-right: 8px;"></i>Sobre Nosotros
      </h4>
      <p style="margin: 8px 0; line-height: 1.5;">
        Somos una hamburguesería apasionada por la calidad y el sabor. Ofrecemos ingredientes frescos, atención personalizada y un ambiente acogedor para toda la familia.
      </p>
    </div>

    <!-- Promesa & Métodos de Pago -->
    <div style="flex: 1 1 250px; min-width: 220px;">
      <h4 style="font-weight: 700; font-size: 1.2em; margin-bottom: 16px;">
        <i class="fas fa-star" style="margin-right: 8px;"></i>Nuestra Promesa
      </h4>
      <p style="margin: 8px 0; line-height: 1.5;">
        100% ingredientes frescos, atención rápida y hamburguesas irresistibles.  
        ¡Te esperamos para que vivas la mejor experiencia Saya Burger!
      </p>

      <div style="margin-top: 16px;">
        <span style="display: flex; align-items: center; gap: 6px;">
          <i class="fas fa-truck fa-lg"></i> Delivery a Domicilio
        </span>
        <span style="display: flex; align-items: center; gap: 6px;">
          <i class="fas fa-store fa-lg"></i> Recoge en el Local
        </span>
    </div>

  </div>

  <div style="border-top: 1px solid #222; text-align: center; padding: 20px 0 12px; width: 100%; font-size: 14px;">
  &copy; {{ date('Y') }} Saya Burger. Todos los derechos reservados.
</div>

</footer>

</body>
</html>
