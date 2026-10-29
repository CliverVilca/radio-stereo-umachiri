@extends('layouts.app')

@section('title', 'Inicio - Radio Stereo Umachiri 98.5 FM | Noticias y Música en Vivo')
@section('description', 'Radio Stereo Umachiri 98.5 FM — La voz líder del altiplano. Cobertura de noticias en vivo, deportes, música y cultura desde Umachiri, Melgar, Puno.')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     HERO BROADCAST — Estudio Radial & Transmisión en Directo (Estilo RPP)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="broadcast-hero position-relative">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            {{-- Columna Izquierda: Titular de Alto Impacto --}}
            <div class="col-lg-7">
                <div class="pe-lg-3">
                    {{-- Badge En Vivo con animación --}}
                    <div class="d-inline-flex align-items-center gap-2 mb-3">
                        <span class="live-pill">
                            <span class="dot-live"></span>
                            TRANSMISIÓN EN VIVO · 98.5 FM
                        </span>
                        <span class="badge rounded-pill px-3 py-1.5 text-dark fw-bold d-none d-sm-inline-block" style="background: var(--rpp-yellow); font-family: var(--font-display); letter-spacing: 0.05em;">
                            LA VOZ DE MELGAR
                        </span>
                    </div>

                    {{-- Titular Principal con Tipografía Contundente --}}
                    <h1 class="text-white mb-3" style="font-family: var(--font-heading); font-weight: 900; font-size: clamp(2.4rem, 5.5vw, 4rem); line-height: 1.05; letter-spacing: -0.04em;">
                        INFORMACIÓN AL INSTANTE Y LA MEJOR MÚSICA
                    </h1>
                    
                    <p class="lead text-white-50 mb-4" style="font-size: 1.15rem; font-weight: 500; line-height: 1.6; max-width: 580px;">
                        Desde el corazón de Umachiri para toda la provincia de Melgar y la región Puno. Cobertura periodística veraz, deportes, opinión y entretenimiento las 24 horas.
                    </p>

                    {{-- Acciones Principales --}}
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <button onclick="document.querySelector('#btn-play')?.click()" class="btn-rpp-play">
                            <i class="fas fa-play"></i>
                            <span>ESCUCHAR RADIO EN VIVO</span>
                            <div class="sound-equalizer ms-1">
                                <span class="eq-bar" style="background:#080d1f;"></span>
                                <span class="eq-bar" style="background:#080d1f;"></span>
                                <span class="eq-bar" style="background:#080d1f;"></span>
                                <span class="eq-bar" style="background:#080d1f;"></span>
                            </div>
                        </button>

                        <a href="{{ route('public.programs.index') }}" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold" style="font-family: var(--font-heading); font-size: 0.95rem; border-width: 2px; letter-spacing: 0.02em;">
                            <i class="fas fa-calendar-alt me-2 text-warning"></i> PROGRAMACIÓN
                        </a>

                        <a href="https://wa.me/51951391524" target="_blank" class="btn btn-success rounded-pill px-3 py-3 fw-bold d-inline-flex align-items-center gap-2 shadow" style="font-family: var(--font-heading); font-size: 0.95rem; background: #22c55e; border-color: #22c55e;">
                            <i class="fab fa-whatsapp fa-lg"></i>
                            <span class="d-none d-sm-inline">Cabina WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Columna Derecha: Tarjeta Interactiva "Al Aire Ahora" con Foto Real de Estudio --}}
            <div class="col-lg-5">
                <div class="on-air-card">
                    {{-- Cabecera Al Aire con Studio Banner --}}
                    <div class="position-relative rounded-4 overflow-hidden mb-3" style="height: 140px; box-shadow: inset 0 0 40px rgba(0,0,0,0.6);">
                        <img src="{{ asset('assets/images/radio-studio-modern.jpg') }}" alt="Estudio Radio Stereo Umachiri" style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.75);">
                        <div class="position-absolute top-0 start-0 end-0 bottom-0 p-3 d-flex flex-column justify-content-between" style="background: linear-gradient(180deg, rgba(10,17,40,0.4) 0%, rgba(10,17,40,0.85) 100%);">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="badge rounded-pill px-3 py-1.5 text-white fw-bold d-inline-flex align-items-center gap-2" style="background: rgba(239, 68, 68, 0.9); font-family: var(--font-display); letter-spacing: 0.08em; font-size: 0.75rem;">
                                    <span class="pulse-circle" style="background: white; width: 7px; height: 7px;"></span> EN DIRECTO
                                </span>
                                <span class="badge rounded-pill px-2.5 py-1 text-dark fw-bold" style="background: var(--rpp-yellow); font-family: var(--font-display); font-size: 0.72rem;">
                                    ESTUDIO CENTRAL
                                </span>
                            </div>
                            <div class="text-white small fw-bold" style="font-family: var(--font-heading); text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                                <i class="fas fa-tower-broadcast text-warning me-1"></i> PLANTA TRANSMISORA UMACHIRI
                            </div>
                        </div>
                    </div>

                    {{-- Dial Display --}}
                    <div class="text-center py-2.5 my-2 rounded-4" style="background: rgba(0,0,0,0.4); border: 1px solid rgba(250,204,21,0.25);">
                        <div class="dial-tag text-white-50 small mb-0" style="font-size: 0.75rem;">FRECUENCIA MODULADA</div>
                        <div class="dial-display" style="font-size: 3.6rem;">
                            98.5 <span class="dial-unit">FM</span>
                        </div>
                        <div class="text-warning small fw-bold" style="font-family: var(--font-heading); letter-spacing: 0.05em; font-size: 0.8rem;">
                            STEREO UMACHIRI · POTENCIA TOTAL
                        </div>
                    </div>

                    {{-- Programa Actual en Vivo --}}
                    <div class="d-flex align-items-center gap-3 mt-3 pt-2">
                        <div class="rounded-circle p-1.5 flex-shrink-0" style="background: rgba(250,204,21,0.15); border: 2px solid var(--rpp-yellow);">
                            <img src="{{ asset('assets/images/logo-modern.jpg') }}" alt="Logo" width="46" height="46" class="rounded-circle object-fit-cover" onerror="this.src='{{ asset('assets/images/logo.png') }}'">
                        </div>
                        <div class="flex-fill overflow-hidden">
                            <span class="badge px-2 py-0.5 rounded text-dark fw-bold mb-1" style="background: var(--rpp-yellow); font-size: 0.68rem; font-family: var(--font-display);">
                                PROGRAMA ESTELAR
                            </span>
                            <h4 class="text-white fw-bold mb-0 text-truncate" style="font-size: 1.1rem;">
                                @if(isset($featuredPrograms) && $featuredPrograms->count() > 0)
                                    {{ $featuredPrograms->first()->title }}
                                @else
                                    Despertar Umachiri & Actualidad
                                @endif
                            </h4>
                            <small class="text-white-50">
                                <i class="fas fa-microphone me-1 text-warning"></i>
                                @if(isset($featuredPrograms) && $featuredPrograms->count() > 0)
                                    Conduce: {{ $featuredPrograms->first()->host ?? 'Equipo Prensa' }}
                                @else
                                    Conduce: Juan Carlos Huanca
                                @endif
                            </small>
                        </div>
                    </div>

                    {{-- Botón rápido para participar en vivo --}}
                    <div class="mt-3 pt-3 border-top border-light border-opacity-10 d-flex align-items-center justify-content-between">
                        <span class="text-white-50 small">¿Enviar saludos o reportes?</span>
                        <a href="https://wa.me/51951391524" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold" style="font-family: var(--font-heading);">
                            <i class="fab fa-whatsapp me-1 text-success"></i> WhatsApp Cabina
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BARRA DE MÉTRICAS & IDENTIDAD RADIAL
     ═══════════════════════════════════════════════════════════════ --}}
<div class="py-3 border-bottom shadow-sm" style="background: white;">
    <div class="container">
        <div class="row g-3 text-center justify-content-center align-items-center">
            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(250,204,21,0.15); color: #b45309;">
                        <i class="fas fa-broadcast-tower fa-xl"></i>
                    </div>
                    <div class="text-start">
                        <div class="h4 fw-black mb-0" style="font-family: var(--font-display); color: #0a1128;">98.5 FM</div>
                        <div class="small text-muted fw-bold">Frecuencia Oficial</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(239,68,68,0.12); color: #ef4444;">
                        <i class="fas fa-clock fa-xl"></i>
                    </div>
                    <div class="text-start">
                        <div class="h4 fw-black mb-0" style="font-family: var(--font-display); color: #0a1128;">24 HORAS</div>
                        <div class="small text-muted fw-bold">Al Aire Sin Cortes</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(16,185,129,0.12); color: #10b981;">
                        <i class="fas fa-map-marked-alt fa-xl"></i>
                    </div>
                    <div class="text-start">
                        <div class="h4 fw-black mb-0" style="font-family: var(--font-display); color: #0a1128;">MELGAR - PUNO</div>
                        <div class="small text-muted fw-bold">Cobertura Regional</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: rgba(59,130,246,0.12); color: #2563eb;">
                        <i class="fas fa-headphones-simple fa-xl"></i>
                    </div>
                    <div class="text-start">
                        <div class="h4 fw-black mb-0" style="font-family: var(--font-display); color: #0a1128;">AUDIO HD</div>
                        <div class="small text-muted fw-bold">Sonido Digital</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     SECCIÓN NOTICIAS — Formato Portal Informativo (Estilo RPP)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-5" style="background: var(--bg-body, #f8fafc);">
    <div class="container">
        {{-- Encabezado de Sección con estilo prensa --}}
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 pb-3 border-bottom border-secondary border-opacity-10 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-broadcast badge-live">🔴 LO ÚLTIMO</span>
                    <span class="text-muted small fw-bold" style="font-family: var(--font-display); letter-spacing: 0.05em;">INFORMACIÓN VERAZ</span>
                </div>
                <h2 class="h1 fw-black mb-0" style="font-family: var(--font-heading); color: var(--rpp-dark); letter-spacing: -0.04em;">
                    PORTAL DE NOTICIAS
                </h2>
            </div>
            <a href="{{ route('noticias.index') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4 shadow-sm" style="font-family: var(--font-heading); font-size: 0.88rem;">
                VER TODAS LAS NOTICIAS <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        {{-- Grid de Noticias --}}
        @if(isset($latestNews) && $latestNews->count() > 0)
            <div class="row g-4">
                {{-- Noticia Principal de Portada (Lead Story) --}}
                @php $leadNews = $latestNews->first(); $secondaryNews = $latestNews->skip(1); @endphp
                <div class="col-lg-7">
                    <a href="{{ route('noticias.show', $leadNews->id) }}" class="text-decoration-none">
                        <article class="rpp-card h-100 shadow-sm">
                            <div class="card-img-wrap" style="height: 340px;">
                                @if($leadNews->image)
                                    <img src="{{ asset('storage/' . $leadNews->image) }}" alt="{{ $leadNews->title }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/cultura-folklore.jpg') }}';">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0a1128, #1d4ed8); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-newspaper fa-4x text-white opacity-40"></i>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge-broadcast badge-breaking shadow">
                                        <i class="fas fa-star me-1"></i> PRINCIPAL
                                    </span>
                                </div>
                                <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(to top, rgba(10,17,40,0.9) 0%, transparent 100%);">
                                    <span class="badge rounded-pill px-2.5 py-1 text-white" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); font-size: 0.75rem;">
                                        {{ ucfirst($leadNews->type) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 d-flex flex-column flex-fill">
                                <div class="d-flex align-items-center gap-2 mb-2 text-muted small">
                                    <i class="far fa-clock text-warning"></i>
                                    <span>{{ $leadNews->published_at ? $leadNews->published_at->diffForHumans() : $leadNews->created_at->diffForHumans() }}</span>
                                    <span>·</span>
                                    <span><i class="fas fa-user-circle text-primary me-1"></i>{{ $leadNews->author ?? 'Redacción' }}</span>
                                </div>
                                <h3 class="rpp-title fw-black mb-3" style="font-size: 1.55rem; line-height: 1.25;">
                                    {{ $leadNews->title }}
                                </h3>
                                <p class="text-muted mb-4 flex-fill" style="font-size: 0.95rem; line-height: 1.6;">
                                    {{ Str::limit(strip_tags($leadNews->content), 180) }}
                                </p>
                                <div class="pt-3 border-top d-flex align-items-center justify-content-between">
                                    <span class="text-primary fw-bold small" style="font-family: var(--font-heading);">
                                        LEER NOTICIA COMPLETA <i class="fas fa-chevron-right ms-1"></i>
                                    </span>
                                    <span class="badge rounded-pill px-2.5 py-1 text-dark" style="background: rgba(250,204,21,0.2);">
                                        <i class="fas fa-volume-high me-1 text-warning"></i> Cobertura 98.5 FM
                                    </span>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>

                {{-- Noticias Secundarias en Columna --}}
                <div class="col-lg-5">
                    <div class="d-flex flex-column gap-3 h-100">
                        @foreach($secondaryNews as $item)
                            <a href="{{ route('noticias.show', $item->id) }}" class="text-decoration-none flex-fill">
                                <article class="rpp-card h-100 p-3 p-md-4">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-4 col-sm-3 col-lg-4">
                                            <div class="card-img-wrap rounded-3" style="height: 110px;">
                                                @if($item->image)
                                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="rounded-3" onerror="this.onerror=null; this.src='{{ asset('assets/images/radio-news-reporting.jpg') }}';">
                                                @else
                                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0a1128, #1e3a8a); display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-newspaper text-white opacity-40"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-8 col-sm-9 col-lg-8">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <span class="badge-broadcast badge-audio" style="font-size: 0.65rem; padding: 0.2rem 0.5rem;">
                                                    {{ strtoupper($item->type) }}
                                                </span>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    {{ $item->published_at ? $item->published_at->diffForHumans() : $item->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <h4 class="rpp-title mb-1" style="font-size: 1.05rem; line-height: 1.3;">
                                                {{ Str::limit($item->title, 75) }}
                                            </h4>
                                            <small class="text-muted d-none d-sm-block">
                                                {{ Str::limit(strip_tags($item->content), 85) }}
                                            </small>
                                        </div>
                                    </div>
                                </article>
                            </a>
                        @endforeach

                        {{-- Caja de Aviso Directo Cabina --}}
                        <div class="rounded-4 p-4 text-white shadow-sm position-relative overflow-hidden mt-auto" style="background: linear-gradient(135deg, #080d1f 0%, #1e3a8a 100%); border-left: 4px solid var(--rpp-yellow);">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle p-3" style="background: rgba(250,204,21,0.2);">
                                    <i class="fas fa-bullhorn fa-lg text-warning"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1 text-white" style="font-size: 1.05rem;">¿Tienes una noticia o denuncia?</h5>
                                    <p class="small text-white-50 mb-0">Contáctate con nuestra mesa periodística al instante.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
                <i class="fas fa-newspaper fa-3x text-muted mb-3 opacity-40"></i>
                <h5 class="fw-bold">No hay noticias publicadas por el momento.</h5>
            </div>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PROGRAMACIÓN ESTELAR — Parrilla y Conducción
     ═══════════════════════════════════════════════════════════════ --}}
@if(isset($featuredPrograms) && $featuredPrograms->count() > 0)
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 pb-3 border-bottom border-secondary border-opacity-10 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-broadcast badge-green">📻 EN PARRILLA</span>
                    <span class="text-muted small fw-bold" style="font-family: var(--font-display);">LA VOZ DEL ALTIPLANO</span>
                </div>
                <h2 class="h1 fw-black mb-0" style="font-family: var(--font-heading); color: var(--rpp-dark); letter-spacing: -0.04em;">
                    PROGRAMAS DESTACADOS
                </h2>
            </div>
            <a href="{{ route('public.programs.index') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4 shadow-sm" style="font-family: var(--font-heading); font-size: 0.88rem;">
                VER PARRILLA COMPLETA <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredPrograms as $program)
                <div class="col-md-6 col-lg-4">
                    <article class="rpp-card h-100 shadow-sm">
                        <div class="card-img-wrap" style="height: 190px;">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/radio-studio-modern.jpg') }}';">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0a1128, #1e3a8a); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-microphone-lines fa-3x text-white opacity-40"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge-broadcast badge-breaking">
                                    <i class="fas fa-star me-1"></i> DESTACADO
                                </span>
                            </div>
                            <div class="position-absolute bottom-0 start-0 m-3">
                                <span class="badge rounded-pill px-3 py-1.5" style="background: rgba(10,17,40,0.88); backdrop-filter: blur(8px); color: white; font-family: var(--font-display); font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="far fa-clock me-1 text-warning"></i>{{ $program->start_time }} – {{ $program->end_time }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 d-flex flex-column flex-fill">
                            <h3 class="rpp-title mb-2" style="font-size: 1.25rem;">{{ $program->title }}</h3>
                            @if($program->description)
                                <p class="text-muted mb-3 flex-fill" style="font-size: 0.88rem; line-height: 1.55;">
                                    {{ Str::limit($program->description, 100) }}
                                </p>
                            @endif
                            <div class="pt-3 border-top mt-auto d-flex align-items-center justify-content-between">
                                <small class="text-muted">
                                    <i class="fas fa-user-circle me-1 text-primary"></i>
                                    <strong>{{ Str::limit($program->host, 20) }}</strong>
                                </small>
                                <a href="{{ route('public.programs.podcasts', $program->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-family: var(--font-heading); font-size: 0.8rem;">
                                    <i class="fas fa-headphones me-1 text-warning"></i> Podcasts
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     DEPORTES & COBERTURA REGIONAL (Estilo RPP Deportes)
     ═══════════════════════════════════════════════════════════════ --}}
@if(isset($featuredSports) && $featuredSports->count() > 0)
<section class="py-5" style="background: #080d1f; color: white;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 pb-3 border-bottom border-light border-opacity-10 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-broadcast badge-breaking">⚽ UMACHIRI DEPORTES</span>
                    <span class="text-white-50 small fw-bold" style="font-family: var(--font-display);">COPA PERÚ & LIGAS LOCALES</span>
                </div>
                <h2 class="h1 fw-black text-white mb-0" style="font-family: var(--font-heading); letter-spacing: -0.04em;">
                    ACTUALIDAD DEPORTIVA
                </h2>
            </div>
            <a href="{{ route('public.sports.index') }}" class="btn btn-outline-warning rounded-pill fw-bold px-4" style="font-family: var(--font-heading); font-size: 0.88rem;">
                MÁS DEPORTES <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredSports as $sport)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('public.sports.show', $sport->id) }}" class="text-decoration-none">
                        <article class="rpp-card h-100 text-white" style="background: #0f1c3f; border-color: rgba(255,255,255,0.08);">
                            <div class="card-img-wrap" style="height: 200px;">
                                @if($sport->image)
                                    <img src="{{ asset('storage/' . $sport->image) }}" alt="{{ $sport->title }}" onerror="this.onerror=null; this.src='{{ asset('assets/images/sports-soccer.jpg') }}';">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #b45309, #d97706); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-futbol fa-3x text-white opacity-40"></i>
                                    </div>
                                @endif
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge-broadcast badge-breaking">
                                        <i class="fas fa-trophy me-1"></i> DEPORTES
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 d-flex flex-column flex-fill">
                                <small class="text-white-50 mb-2">
                                    <i class="far fa-clock me-1 text-warning"></i>
                                    {{ $sport->published_at ? $sport->published_at->diffForHumans() : $sport->created_at->diffForHumans() }}
                                </small>
                                <h4 class="text-white fw-bold mb-2" style="font-size: 1.18rem; line-height: 1.3;">
                                    {{ $sport->title }}
                                </h4>
                                <p class="text-white-50 small mb-0 flex-fill">
                                    {{ Str::limit(strip_tags($sport->content), 95) }}
                                </p>
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     EVENTOS Y AGENDA CULTURAL
     ═══════════════════════════════════════════════════════════════ --}}
@if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
<section class="py-5" style="background: var(--bg-body, #f8fafc);">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 pb-3 border-bottom border-secondary border-opacity-10 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-broadcast badge-audio">📅 AGENDA</span>
                    <span class="text-muted small fw-bold" style="font-family: var(--font-display);">ACTIVIDADES EN MELGAR</span>
                </div>
                <h2 class="h1 fw-black mb-0" style="font-family: var(--font-heading); color: var(--rpp-dark); letter-spacing: -0.04em;">
                    PRÓXIMOS EVENTOS
                </h2>
            </div>
            <a href="{{ route('public.events.index') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4" style="font-family: var(--font-heading); font-size: 0.88rem;">
                VER TODOS <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($upcomingEvents as $event)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('public.events.show', $event->id) }}" class="text-decoration-none">
                        <article class="rpp-card h-100 shadow-sm p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="text-center rounded-3 px-3 py-2 flex-shrink-0 shadow-sm" style="background: linear-gradient(135deg, var(--rpp-yellow), #eab308); color: #080d1f; min-width: 60px;">
                                    <div class="fw-black" style="font-family: var(--font-display); font-size: 1.6rem; line-height: 1;">{{ $event->start_time->format('d') }}</div>
                                    <div style="font-family: var(--font-display); font-size: 0.72rem; font-weight: 800; text-transform: uppercase;">{{ $event->start_time->format('M') }}</div>
                                </div>
                                <div class="flex-fill">
                                    <h4 class="rpp-title mb-1" style="font-size: 1.1rem; line-height: 1.35;">{{ $event->title }}</h4>
                                    <small class="text-muted d-block mb-2">
                                        <i class="far fa-clock me-1 text-warning"></i>{{ $event->start_time->format('H:i') }}
                                        @if($event->location) · <i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ Str::limit($event->location, 25) }} @endif
                                    </small>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
