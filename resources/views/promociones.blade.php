<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Promociones | Saya Burguer</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/promocion.css') }}" />
    <script src="https://kit.fontawesome.com/a2d4f54cbc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    {{-- HEADER --}}
    {{-- Incluye la plantilla del header --}}
    @include('partials.header', [
        'contador' => $contador ?? 0,
        'carritoItems' => $carritoItems ?? collect(),
        'promocionItems' => $promocionItems ?? collect(), // <--- Agrega esta línea
        'totalPrice' => $totalPrice ?? 0,
    ])

    <main class="promotions-main-content">
        <section class="hero-promotions">
            <div class="hero-content">
                <h1>¡Ofertas Irresistibles en Saya Burguer!</h1>
                <p>Descubre nuestros combos y promociones especiales diseñados para ti.</p>
            </div>
        </section>

        <section class="promotions-list-section">
            <h2 class="section-title">Nuestras Promociones del Mes</h2>
            <p class="section-subtitle">¡Aprovecha y disfruta de tus favoritos a un precio increíble!</p>

            @if ($promociones->isEmpty())
                <div class="no-promotions-message">
                    <i class="fas fa-burger-soda"></i>
                    <p>¡Ups! Parece que no hay promociones activas en este momento. ¡Vuelve pronto para nuevas ofertas!
                    </p>
                </div>
            @else
                <div class="promotions-grid">
                    @foreach ($promociones as $promocion)
                        <div class="promotion-card" data-promotion-id="{{ $promocion->id }}">
                            <div class="promotion-image-wrapper">
                                @if ($promocion->imagen_url)
                                    {{-- **IMPORTANTE: Asegúrate de que $promocion->imagen_url contenga la ruta correcta, ej: 'promociones/mi-imagen.jpg'** --}}
                                    <img src="{{ asset('storage/img/promociones/' . $promocion->imagen_url) }}"
                                        alt="{{ $promocion->nombre }}" class="promotion-image">
                                @else
                                    {{-- Placeholder si no hay imagen (asegúrate de tener esta imagen en public/img/placeholders/) --}}
                                    <img src="{{ asset('img/placeholders/promo_default.png') }}"
                                        alt="Imagen no disponible" class="promotion-image">
                                @endif
                                <div class="promotion-price-overlay">
                                    <span class="price-label">Solo</span>
                                    <span class="price-value">S/.
                                        {{ number_format($promocion->precio_promocional, 2) }}</span>
                                </div>
                            </div>
                            <div class="promotion-details">
                                <h3 class="promotion-name">{{ $promocion->nombre }}</h3>
                                <p class="promotion-description">{{ Str::limit($promocion->descripcion, 90) }}</p>

                                <div class="promotion-includes-section">
                                    <h4>Esta promoción incluye:</h4>
                                    <ul class="included-products-list">
                                        @forelse ($promocion->detalles as $detalle)
                                            <li>
                                                <i class="fas fa-check-circle"></i>
                                                {{ $detalle->cantidad }}x
                                                {{ $detalle->producto->nombre ?? 'Producto Desconocido' }}
                                            </li>
                                        @empty
                                            <li class="no-items"><i class="fas fa-exclamation-circle"></i> No hay
                                                productos especificados para esta promoción.</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <button class="add-to-cart-promo-btn" data-promotion-id="{{ $promocion->id }}">
                                    Añadir al Carrito <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </main>

    {{-- Script para manejar la adición de promociones al carrito --}}
    <script>
        window.routes = {
            addToCartPromo: "{{ route('carrito.addPromo') }}",
            perfil: "{{ route('perfil') }}",
            login: "{{ route('login') }}"
        };

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart-promo-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const promotionId = this.dataset.promotionId;
                    const quantity = 1;

                    try {
                        const response = await fetch(window.routes.addToCartPromo, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                promocion_id: promotionId,
                                cantidad: quantity
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message ||
                                'Error al añadir la promoción al carrito.');
                        }

                        const data = await response.json();
                        if (data.success) {
                            if (typeof window.updateCartUI === 'function') {
                                window.updateCartUI(data);
                            } else {
                                console.warn(
                                    'window.updateCartUI no está definida. El carrito no se actualizará visualmente.'
                                    );
                            }

                            Swal.fire({
                                icon: 'success',
                                title: '¡Promoción Añadida!',
                                text: data.message ||
                                    'La promoción ha sido añadida a tu carrito.',
                                showConfirmButton: false,
                                timer: 1800
                            });
                        } else {
                            Swal.fire('Error', data.message ||
                                'No se pudo añadir la promoción al carrito.', 'error');
                        }
                    } catch (error) {
                        console.error('Error al añadir promoción al carrito:', error);
                        Swal.fire('Error', 'Hubo un problema al añadir la promoción: ' + error
                            .message, 'error');
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('js/header.js') }}"></script>

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
