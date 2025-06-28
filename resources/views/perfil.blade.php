<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Saya Burguer - Perfil</title>

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/usuario/perfil.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />

    <!-- Íconos -->
    <script src="https://kit.fontawesome.com/a2d4f54cbc.js" crossorigin="anonymous"></script>

    <!-- SweetAlert y animaciones -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .oculto {
            display: none;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    @include('partials.header')

    {{-- Contenido principal --}}
    <main>
        <section class="perfil-card">
            <div class="perfil-title">
                <div class="perfil-title-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h2>Mi Perfil</h2>
            </div>

            <div class="perfil-info">
                <div>
                    <span>Nombre:</span>
                    <p>
                        @if(empty(Auth::user()->nombre) && empty(Auth::user()->apellido))
                            <span class="no-registrado">No registrado</span>
                        @else
                            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                        @endif
                    </p>
                </div>
                <div>
                    <span>Email:</span>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <span>Teléfono:</span>
                    <p>
                        @if(empty(Auth::user()->telefono))
                            <span class="no-registrado">No registrado</span>
                        @else
                            {{ Auth::user()->telefono }}
                        @endif
                    </p>
                </div>
                <div>
                    <span>Dirección:</span>
                    <p>
                        @if(empty(Auth::user()->direccion))
                            <span class="no-registrado">No registrada</span>
                        @else
                            {{ Auth::user()->direccion }}
                        @endif
                    </p>
                </div>
                <div>
                    <span>Fecha de registro:</span>
                    <p>{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <button onclick="document.getElementById('modalPerfil').classList.remove('oculto')" class="btn-editar">
                <i class="fas fa-edit animate-pulse"></i> Editar Perfil
            </button>
        </section>
    </main>

    {{-- Modal de edición --}}
    <div id="modalPerfil" class="modal oculto">
        <div class="modal-box">
            <button onclick="document.getElementById('modalPerfil').classList.add('oculto')" class="btn-cerrar">
                <i class="fas fa-times-circle"></i>
            </button>
            <h3 class="perfil-title">
                <i class="fas fa-user-edit"></i> Editar Perfil
            </h3>
            <form method="POST" action="{{ route('perfil.actualizar') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label>Nombre</label>
                    <input name="nombre" value="{{ Auth::user()->nombre }}" required>
                </div>

                <div>
                    <label>Apellido</label>
                    <input name="apellido" value="{{ Auth::user()->apellido }}" required>
                </div>

                <div>
                    <label>Email</label>
                    <input name="email" type="email" value="{{ Auth::user()->email }}" required>
                </div>

                <div>
                    <label>Teléfono</label>
                    <input name="telefono" value="{{ Auth::user()->telefono }}">
                </div>

                <div>
                    <label>Dirección</label>
                    <input name="direccion" value="{{ Auth::user()->direccion }}">
                </div>

                <div style="text-align: right; padding-top: 1rem;">
                    <button type="submit" class="btn-guardar">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS para rutas --}}
    <script>
        window.routes = {
            productosFiltrar: "{{ route('productos.filtrar') }}",
            perfil: "{{ route('perfil') }}",
            login: "{{ route('register') }}"
        };
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
