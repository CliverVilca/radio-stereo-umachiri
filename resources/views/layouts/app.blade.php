<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Radio Stereo Umachiri, la voz de la comunidad. Noticias, música y cultura desde Melgar, Puno.')">
    <meta name="keywords" content="radio, stereo, umachiri, puno, melgar, noticias, musica, en vivo">
    <meta name="author" content="Stereo Umachiri">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Stereo Umachiri - La Voz de la Comunidad')</title>

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts: Montserrat (Bold Display), Oswald (Broadcast Kickers) & Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;0,800;0,900;1,700&family=Oswald:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Base Theme & Components -->
    <link href="{{ asset('css/app-optimized.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/radio-player.css') }}" rel="stylesheet">

    <!-- Premium Theme (Last to override) -->
    <link href="{{ asset('css/premium.css') }}" rel="stylesheet">
    
    @stack('styles')
    @livewireStyles

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Meta tags for PWA -->
    <meta name="theme-color" content="#0a1128">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Stereo Umachiri">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Stereo Umachiri')">
    <meta property="og:description" content="@yield('description', 'Radio Stereo Umachiri, la voz de la comunidad.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/logo.png'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Stereo Umachiri')">
    <meta property="twitter:description" content="@yield('description', 'Radio Stereo Umachiri, la voz de la comunidad.')">
    <meta property="twitter:image" content="@yield('og_image', asset('assets/images/logo.png'))">
</head>
<body>
    <!-- Top Broadcast Ribbon (Estilo RPP) -->
    <div class="top-broadcast-bar py-1">
        <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center text-warning small fw-bold">
                    <span class="pulse-circle me-1.5" style="background:#ef4444; width:8px; height:8px;"></span>
                    <span style="font-family:'Oswald',sans-serif; letter-spacing:0.06em;">EN DIRECTO</span>
                </span>
                <span class="text-white-50">|</span>
                <span class="text-white small fw-bold" style="font-family:'Montserrat',sans-serif;">
                    STEREO UMACHIRI 98.5 FM — MELGAR, PUNO
                </span>
            </div>
            <div class="d-flex align-items-center gap-3 ms-auto small">
                <a href="https://wa.me/51951391524" target="_blank" class="badge rounded-pill text-dark fw-bold text-decoration-none px-3 py-1" style="background:var(--rpp-yellow); font-family:'Montserrat',sans-serif;">
                    <i class="fab fa-whatsapp me-1 text-dark"></i> Cabina: 951 391 524
                </a>
            </div>
        </div>
    </div>

    <!-- Breaking News Ticker (Último Minuto) -->
    <div class="breaking-ticker-wrap">
        <div class="breaking-label">
            <span class="pulse-circle"></span>
            <span>ÚLTIMO MINUTO</span>
        </div>
        <div class="ticker-text flex-fill">
            <marquee behavior="scroll" direction="left" scrollamount="6" onmouseover="this.stop();" onmouseout="this.start();">
                📻 Transmitiendo en vivo 98.5 FM desde Umachiri, Melgar, Puno &nbsp;&bull;&nbsp; Sintoniza las últimas noticias locales y regionales &nbsp;&bull;&nbsp; Participa en vivo enviando tu mensaje al WhatsApp de cabina 951 391 524
            </marquee>
        </div>
    </div>

    <!-- Modern Broadcast Navbar -->
    <nav class="modern-navbar navbar navbar-expand-lg navbar-light py-2">
        <div class="container">
            <a class="modern-logo d-flex align-items-center text-decoration-none" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-modern.jpg') }}" alt="Stereo Umachiri" height="48" class="me-2 rounded-circle shadow-sm" style="border: 2px solid var(--rpp-yellow);">
                <div class="d-flex flex-column">
                    <span class="brand-title" style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.45rem; color: #0a1128; letter-spacing: -0.04em; line-height: 1;">STEREO UMACHIRI</span>
                    <span class="brand-subtitle" style="font-family: 'Oswald', sans-serif; font-size: 0.72rem; letter-spacing: 0.12em; color: #b45309; font-weight: 700; text-transform: uppercase;">98.5 FM · LA VOZ DEL ALTIPLANO</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="modern-nav-link {{ request()->is('noticias*') ? 'active' : '' }} d-flex align-items-center" href="{{ route('noticias.index') }}">
                            <i class="fas fa-newspaper me-1"></i> Noticias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="modern-nav-link {{ request()->is('deportes*') ? 'active' : '' }} d-flex align-items-center" href="{{ route('public.sports.index') }}">
                            <i class="fas fa-running me-1"></i> Deportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="modern-nav-link {{ request()->is('programacion*') ? 'active' : '' }} d-flex align-items-center" href="{{ route('public.programs.index') }}">
                            <i class="fas fa-microphone me-1"></i> Programación
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="modern-nav-link {{ request()->is('eventos*') ? 'active' : '' }} d-flex align-items-center" href="{{ route('public.events.index') }}">
                            <i class="fas fa-calendar me-1"></i> Eventos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="modern-nav-link {{ request()->is('galeria*') ? 'active' : '' }} d-flex align-items-center" href="{{ route('public.galleries.index') }}">
                            <i class="fas fa-images me-1"></i> Galería
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="modern-nav-link {{ request()->is('contact*') ? 'active' : '' }} d-flex align-items-center" href="{{ route('contact.index') }}">
                            <i class="fas fa-envelope me-1"></i> Contacto
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <!-- Dark Mode Toggle -->
                    <li class="nav-item">
                        <button id="darkModeToggle" class="btn btn-link nav-link d-flex align-items-center" title="Cambiar modo">
                            <i class="fas fa-moon me-1"></i> <span class="d-none d-sm-inline">Modo</span>
                        </button>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->email === 'admin@admin.com')
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-cog me-2"></i> Panel Admin
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" style="padding-bottom: 100px;">
        @yield('content')
    </main>

    <!-- Fixed Bottom Radio Player -->
    <div class="fixed-bottom-radio-player">
        @livewire('radio-player')
    </div>

    <!-- Modern Footer -->
    <footer class="footer mt-5 py-5" style="background: var(--bg-dark); color: white; border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('assets/images/logo-modern.jpg') }}" alt="Logo" height="46" class="me-2 rounded-circle shadow-sm" style="border: 2px solid var(--rpp-yellow);">
                            <h5 class="fw-bold m-0 text-white" style="font-family: 'Outfit', sans-serif;">Stereo Umachiri</h5>
                        </div>
                        <p class="text-white-50 mb-4" style="font-size: 0.95rem;">Liderando la comunicación en nuestra comunidad con integridad, pasión y la mejor calidad de sonido.</p>
                        <div class="social-links d-flex gap-3">
                            <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-btn"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <h6 class="fw-bold mb-4 text-white">Explorar</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary">Inicio</a></li>
                        <li class="mb-3"><a href="{{ route('noticias.index') }}" class="text-white-50 text-decoration-none hover-primary">Noticias</a></li>
                        <li class="mb-3"><a href="{{ route('public.sports.index') }}" class="text-white-50 text-decoration-none hover-primary">Deportes</a></li>
                    </ul>
                </div>

                <div class="col-lg-2">
                    <h6 class="fw-bold mb-4 text-white">Comunidad</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3"><a href="{{ route('public.events.index') }}" class="text-white-50 text-decoration-none hover-primary">Eventos</a></li>
                        <li class="mb-3"><a href="{{ route('public.galleries.index') }}" class="text-white-50 text-decoration-none hover-primary">Galería</a></li>
                        <li class="mb-3"><a href="{{ route('contact.index') }}" class="text-white-50 text-decoration-none hover-primary">Contacto</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h6 class="fw-bold mb-4 text-white">Contacto Directo</h6>
                    <div class="contact-info">
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon-wrap me-3"><i class="fas fa-map-marker-alt text-warning"></i></div>
                            <span class="text-white-50 small">Umachiri, Melgar - Puno, Perú</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon-wrap me-3"><i class="fas fa-phone text-warning"></i></div>
                            <span class="text-white-50 small">+51 951 391 524</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon-wrap me-3"><i class="fab fa-whatsapp text-success"></i></div>
                            <a href="https://wa.me/51951391524" target="_blank" class="text-white-50 small text-decoration-none hover-primary">Chat WhatsApp</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom mt-5 pt-4 border-top border-secondary border-opacity-10 text-center">
                <p class="text-white-50 small mb-0">&copy; {{ date('Y') }} Stereo Umachiri. Elevando tu sintonía.</p>
            </div>
        </div>
    </footer>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- News Modal -->
    @if(isset($latestNewsForModal) && $latestNewsForModal->count() > 0)
        @php
            $modalNews = $latestNewsForModal->first();
        @endphp
        <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="newsModalLabel">
                            <i class="fas fa-newspaper me-2"></i>Última Noticia
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if($modalNews->image)
                                    <img src="{{ asset('storage/' . $modalNews->image) }}"
                                         alt="{{ $modalNews->title }}"
                                         class="img-fluid rounded shadow-sm">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-newspaper fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-primary mb-3">{{ $modalNews->title }}</h4>
                                <p class="text-muted mb-3">
                                    {{ Str::limit(strip_tags($modalNews->content), 150) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $modalNews->published_at->diffForHumans() }}
                                    </small>
                                    <span class="badge bg-primary">{{ ucfirst($modalNews->type) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cerrar
                        </button>
                        <a href="{{ route('noticias.show', $modalNews->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye me-2"></i>Ver Noticia Completa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modern JavaScript -->
    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful');
                }).catch(function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading states
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });

        // Add modern interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to elements
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            /*
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, observerOptions);

            // Observe all cards and sections
            document.querySelectorAll('.card, section').forEach(el => {
                observer.observe(el);
            });
            */

            // News modal auto-show disabled to prevent blocking the screen
            // Can be opened explicitly via trigger if needed
            const newsModal = document.getElementById('newsModal');

            // Dark mode toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            const icon = darkModeToggle.querySelector('i');

            // Check for saved theme preference or default to light mode
            const currentTheme = localStorage.getItem('theme') || 'light';
            if (currentTheme === 'dark') {
                body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }

            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                const isDark = body.classList.contains('dark-mode');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                icon.classList.toggle('fa-moon');
                icon.classList.toggle('fa-sun');
            });
        });
    </script>

    <!-- Modern Theme JavaScript -->
    <script src="{{ asset('js/modern-theme.js') }}"></script>
    
    @livewireScripts
    @stack('scripts')

    <!-- Panel lateral de clima mejorado (Compacto & Wide) -->
    <div id="weatherSidebar" style="position: fixed; top: 0; left: -400px; width: 400px; height: 100vh; background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%); color: white; box-shadow: 5px 0 25px rgba(0,0,0,0.5); transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1); z-index: 1055; overflow: hidden; border-right: 1px solid rgba(255,255,255,0.1);">
        <div class="d-flex flex-column h-100 p-3 p-md-4">
            <!-- Header & Close -->
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-light border-opacity-10">
                <h6 class="fw-bold m-0 text-uppercase tracking-wider"><i class="fas fa-cloud-sun me-2 text-warning"></i>El Clima</h6>
                <button onclick="closeSidebar()" class="btn btn-sm btn-icon text-white-50 hover-white p-0">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>

            <!-- Search Bar (Compacto) -->
            <div class="input-group input-group-sm mb-3">
                <input type="text" id="cityInput" class="form-control bg-dark border-secondary text-white shadow-none" placeholder="Buscar ciudad..." onkeypress="handleCitySearch(event)" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                <button class="btn btn-primary px-3" type="button" onclick="searchCity()" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                    <i class="fas fa-search small"></i>
                </button>
            </div>
            
            <!-- Weather Content -->
            <div id="weatherContent" class="fade-in flex-grow-1 d-flex flex-column" style="min-height: 0;">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            </div>
            
            <!-- Footer Location -->
            <div class="mt-auto pt-2 text-center border-top border-light border-opacity-10">
                <small class="text-white-50" style="font-size: 0.7rem;">Ubicación: <span id="currentCityLabel" class="text-white fw-bold">Melgar, Puno</span></small>
            </div>
        </div>
    </div>

    <style>
        .weather-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            margin-bottom: 0.4rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.2s, background 0.2s;
            font-size: 0.9rem;
        }
        .weather-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
            border-color: rgba(255, 255, 255, 0.1);
        }
        .weather-card:last-child { margin-bottom: 0; }
        
        .main-temp {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -2px;
            background: linear-gradient(to bottom, #fff, #cbd5e1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .weather-icon-lg {
            font-size: 3.5rem;
            filter: drop-shadow(0 0 15px rgba(255, 193, 7, 0.3));
            animation: float-weather 4s ease-in-out infinite;
        }
        @keyframes float-weather {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        
        /* Ajuste de scrollbar fino por si acaso en pantallas muy pequeñas */
        #weatherSidebar::-webkit-scrollbar { width: 4px; }
        #weatherSidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
    </style>

    <script>
        const sidebar = document.getElementById('weatherSidebar');
        let sidebarVisible = false;
        let currentCity = "Melgar, Puno";

        // Sidebar opens on explicit user click, not on accidental mouse hover

        function openSidebar() {
            sidebar.style.left = '0';
            sidebarVisible = true;
            if (!sidebar.dataset.loaded) fetchWeather();
        }

        function closeSidebar() {
            sidebar.style.left = '-400px';
            sidebarVisible = false;
        }

        function handleCitySearch(e) {
            if (e.key === 'Enter') searchCity();
        }

        function searchCity() {
            const input = document.getElementById('cityInput');
            const city = input.value.trim();
            if (!city) return;

            document.getElementById('weatherContent').innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <div class="small text-white-50">Buscando...</div>
                </div>
            `;
            
            document.getElementById('currentCityLabel').textContent = city;
            currentCity = city;
            
            setTimeout(() => {
                sidebar.dataset.loaded = false;
                loadWeatherData('-14.78', '-70.81', true);
                input.value = '';
            }, 800);
        }

        function fetchWeather() {
            if (sidebar.dataset.loaded) return;
            loadWeatherData('-14.78', '-70.81'); 
        }

        function loadWeatherData(lat, lon, isSearch = false) {
            fetch(`/api/weather?lat=${lat}&lon=${lon}&mock=true&t=${Date.now()}`)
                .then(response => response.json())
                .then(data => {
                    sidebar.dataset.loaded = true;
                    renderWeather(data);
                })
                .catch(err => {
                    document.getElementById('weatherContent').innerHTML = '<div class="text-center text-danger h-100 d-flex flex-column justify-content-center"><i class="fas fa-wifi mb-2"></i><p class="small">Sin conexión</p></div>';
                });
        }

        function getWeatherIcon(code) {
            const icons = {
                '01d': 'fa-sun text-warning', '01n': 'fa-moon text-light',
                '02d': 'fa-cloud-sun text-warning', '02n': 'fa-cloud-moon text-light',
                '03d': 'fa-cloud text-light', '03n': 'fa-cloud text-light',
                '04d': 'fa-cloud text-secondary', '04n': 'fa-cloud text-secondary',
                '09d': 'fa-cloud-showers-heavy text-info', '09n': 'fa-cloud-showers-heavy text-info',
                '10d': 'fa-cloud-rain text-primary', '10n': 'fa-cloud-rain text-primary',
                '11d': 'fa-bolt text-warning', '11n': 'fa-bolt text-warning',
                '13d': 'fa-snowflake text-white', '13n': 'fa-snowflake text-white',
                '50d': 'fa-smog text-secondary', '50n': 'fa-smog text-secondary'
            };
            return icons[code] || 'fa-cloud-sun';
        }

        function renderWeather(data) {
            if (!data || data.error) return;

            const current = data.current;
            const daily = data.daily || [];
            const iconClass = getWeatherIcon(current.weather[0].icon || '01d');
            const desc = current.weather[0].description || 'Despejado';

            let html = `
                <div class="text-center py-2 mb-2 flex-shrink-0">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-2">
                        <i class="fas ${iconClass} weather-icon-lg"></i>
                        <div class="text-start">
                             <div class="main-temp">${Math.round(current.temp)}°</div>
                             <div class="text-white-50 text-capitalize small fw-medium" style="margin-top:-5px;">${desc}</div>
                        </div>
                    </div>
                    
                    <div class="row g-2 justify-content-center px-2">
                        <div class="col-6">
                            <div class="bg-white bg-opacity-5 rounded py-1 px-2 d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-tint text-info small opacity-75"></i>
                                <span class="fw-bold small">${current.humidity}%</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-white bg-opacity-5 rounded py-1 px-2 d-flex align-items-center justify-content-center gap-2">
                                <i class="fas fa-wind text-light small opacity-75"></i>
                                <span class="fw-bold small">${current.wind_speed} m/s</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                    <span class="small fw-bold text-white-50 text-uppercase tracking-wide" style="font-size:0.65rem;">Próximos 5 Días</span>
                </div>
                
                <div class="weather-forecast d-flex flex-column gap-1 overflow-y-auto" style="min-height:0;">
            `;

            daily.slice(1, 6).forEach(day => {
                const date = new Date(day.dt * 1000);
                const dayName = date.toLocaleDateString('es-ES', { weekday: 'long' });
                const dayIcon = getWeatherIcon(day.weather[0].icon || '01d');
                
                html += `
                    <div class="weather-card d-flex align-items-center justify-content-between py-2">
                        <div class="text-capitalize fw-medium text-white-50" style="width: 35%; font-size:0.85rem;">${dayName}</div>
                        <div class="text-center" style="width: 20%;">
                            <i class="fas ${dayIcon}"></i>
                        </div>
                        <div class="text-end d-flex justify-content-end gap-2" style="width: 45%;">
                            <span class="fw-bold text-white">${Math.round(day.temp.max)}°</span>
                            <span class="text-white-50 small">${Math.round(day.temp.min)}°</span>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            document.getElementById('weatherContent').innerHTML = html;
        }
    </script>
</body>
</html>
