@extends('layouts.app')

@section('title', 'Contacto - Stereo Umachiri 98.5 FM')
@section('description', 'Contáctanos para publicidad radial, cobertura informativa, saludos o consultas. Stereo Umachiri 98.5 FM - Melgar, Puno.')

@section('content')

{{-- ── PAGE HERO ── --}}
<div class="position-relative overflow-hidden py-5 text-center text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);">
    <div style="position: absolute; right: -5%; top: -40%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(245,158,11,0.18), transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; left: -10%; bottom: -40%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%); pointer-events: none;"></div>

    <div class="container position-relative py-3">
        <nav aria-label="breadcrumb" class="mb-3 d-inline-block">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Contacto</li>
            </ol>
        </nav>

        <div class="d-inline-flex align-items-center justify-content-center rounded-4 shadow-sm mb-3"
             style="width: 64px; height: 64px; background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="fas fa-envelope-open-text text-white fa-xl"></i>
        </div>
        <h1 class="text-white fw-black mb-2" style="font-size: clamp(2rem, 4vw, 2.8rem); letter-spacing: -0.03em;">¡Comunícate con Nosotros!</h1>
        <p class="text-white-50 mb-0 mx-auto" style="max-width: 540px; font-size: 0.98rem; line-height: 1.6;">
            ¿Deseas pautar publicidad, compartir un aviso comunitario o enviar saludos al aire? Escríbenos y nuestro equipo te responderá de inmediato.
        </p>
    </div>
</div>

{{-- ── CONTACT SECTION ── --}}
<section style="background: var(--bg-body, #f8fafc); padding: 3rem 0 4.5rem;">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Contact Info Cards --}}
            <div class="col-lg-4 order-lg-2">
                <div class="d-flex flex-column gap-3">
                    {{-- Phone / WhatsApp --}}
                    <div class="bg-white rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 shadow-sm"
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                                <i class="fas fa-phone-alt text-white"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-bold mb-1">Teléfono / Cabina</div>
                                <a href="tel:+51951391524" class="text-dark fw-bold text-decoration-none" style="font-size: 1.05rem;">+51 951 391 524</a>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp Direct --}}
                    <div class="bg-white rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 shadow-sm"
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #22c55e, #16a34a);">
                                <i class="fab fa-whatsapp text-white fa-lg"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-bold mb-1">WhatsApp Radio</div>
                                <a href="https://wa.me/51951391524" target="_blank" class="text-dark fw-bold text-decoration-none" style="font-size: 0.95rem;">Escribir a Cabina <i class="fas fa-external-link-alt ms-1 small text-muted"></i></a>
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="bg-white rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 shadow-sm"
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-bold mb-1">Correo Electrónico</div>
                                <a href="mailto:radio@stereumachiri.com" class="text-dark fw-bold text-decoration-none" style="font-size: 0.92rem;">radio@stereumachiri.com</a>
                            </div>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="bg-white rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 shadow-sm"
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-bold mb-1">Estudios Principales</div>
                                <div class="text-dark fw-bold" style="font-size: 0.92rem;">Umachiri, Melgar<br><span class="fw-normal text-muted small">Puno, Perú</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Frequency Banner --}}
                    <div class="rounded-4 p-4 text-white text-center shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                        <div style="position: absolute; right: -20px; top: -20px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(245,158,11,0.25), transparent 70%); pointer-events: none;"></div>
                        <i class="fas fa-broadcast-tower fa-2x mb-2 text-warning"></i>
                        <div class="fw-black" style="font-size: 2rem; letter-spacing: -0.02em;">98.5 FM</div>
                        <div class="text-white-50 small mb-3">La frecuencia líder en el corazón de Melgar</div>
                        <a href="https://wa.me/51951391524" target="_blank"
                           class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm"
                           style="color: #0f172a;">
                            <i class="fab fa-whatsapp me-1"></i> Chatear por WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contact Form (Livewire) --}}
            <div class="col-lg-7 order-lg-1">
                <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm h-100" style="border: 1px solid rgba(0,0,0,0.06);">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill px-3 py-1" style="background: rgba(30,58,138,0.1); color: #1e3a8a; font-weight: 700; font-size: 0.75rem;">
                            ATENCIÓN INMEDIATA
                        </span>
                    </div>
                    <h2 class="fw-black mb-1" style="color: var(--text-main, #0f172a); font-size: 1.55rem;">Envíanos un mensaje</h2>
                    <p class="text-muted mb-4" style="font-size: 0.92rem;">Rellena el siguiente formulario para cotizar pauta publicitaria o enviar tus consultas.</p>

                    @if(session('success'))
                        <div class="alert alert-success rounded-3 mb-4 d-flex align-items-center gap-2 shadow-sm">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @livewire('contact-form')
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
