<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Saya Burguer</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DynaPuff&display=swap" rel="stylesheet">
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



    {{-- Tu JavaScript puede quedarse en el archivo principal si es específico de la página,
         o moverlo a un archivo .js externo si es global. --}}
    <section class="hero">
        <div class="contenido-hero">
            <p class="parrafo">Donde cada hamburguesa cuenta una historia de sabor y diversión para toda la familia.</p>
            <h1 class="titulo">¡BIENVENIDOS A SAYA BURGUER!</h1>
            <a href="{{ route('menu') }}" class="boton">Compra ahora</a>
        </div>
    </section>
    <section class="carrusel">
        <div class="carrusel-container">
            <!-- Slide 1 -->
            <div class="slide active">
                <img src="{{ asset('storage/home/sabores.png') }}" alt="Hamburguesa deliciosa">
                <div class="slide-content">
                    <h2>Sabores Únicos</h2>
                    <p>En Saya Burguer, cada bocado de nuestras hamburguesas está diseñado para deleitar tu paladar.
                        Utilizamos ingredientes frescos y de alta calidad, garantizando que cada hamburguesa sea una
                        experiencia irresistible.</p>
                    <a href="{{ route('menu') }}" class="boton-ver-mas">Ver más</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <img src="{{ asset('storage/home/image(7).png') }}" alt="Ambiente familiar en Saya Burguer">
                <div class="slide-content">
                    <h2>Ambiente Familiar</h2>
                    <p>Nuestra hamburguesería es el lugar perfecto para disfrutar con amigos y familiares , Con un
                        ambiente divertido y acogedor.</p>
                    <p><strong>Tu hamburguesa lista en minutos, para que sigas con tu día sin perder sabor.</strong></p>
                    <a href="{{ route('menu') }}" class="boton-ver-mas">Ordena ahora</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <img src="{{ asset('storage/home/rapido.png') }}" alt="Servicio rápido en Saya Burguer">
                <div class="slide-content">
                    <h2>Servicio Rápido</h2>
                    <p><strong>Tu hamburguesa lista en minutos, para que sigas con tu día sin perder sabor.</strong></p>
                    <a href="{{ route('menu') }}" class="boton-ver-mas">Ordena ahora</a>
                </div>
            </div>

            <!-- Dots de navegación -->
            <div class="dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </section>
    <script>
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');
        let currentIndex = 0;
        let interval = setInterval(nextSlide, 5000); // Cambia cada 5 segundos

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
                dots[i].classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                currentIndex = i;
                showSlide(currentIndex);
                clearInterval(interval); // Detiene autoplay cuando se clickea manualmente
                interval = setInterval(nextSlide, 5000); // Reinicia autoplay
            });
        });

        showSlide(currentIndex);
    </script>
    <section class="delicias">
        <h2 class="delicias-titulo">Delicias que no te puedes perder</h2>
        <p class="delicias-subtitulo"><strong>Prueba nuestras especialidades y déjate sorprender por cada sabor.</strong></p>

        <div class="delicias-contenido">
            @forelse($deliciasOrdenadas as $delicia)
                <div class="delicia">
                    <img src="{{ asset('storage/img/productos/' . $delicia->imagen_url) }}" alt="{{ $delicia->nombre }}">
                    <div class="delicia-texto">
                        <h3>{{ $delicia->nombre }}</h3>
                        <p>{{ $delicia->descripcion }}</p>
                        {{-- Puedes añadir un enlace o botón para ver más detalles o añadir al carrito --}}
                        <a href="{{ route('productos.show', $delicia->slug) }}" class="promociones-btn mt-4">Ver Detalles</a> 
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-600">No hay delicias disponibles en este momento.</p>
            @endforelse
        </div>
    </section>

    <script>
        window.routes = {
            productosFiltrar: "{{ route('productos.filtrar') }}",
            perfil: "{{ route('perfil') }}",
            login: "{{ route('login') }}"
            // Añade aquí cualquier otra ruta que necesites en tus JS
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
