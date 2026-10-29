@extends('layouts.app')

@section('title', 'Podcasts de ' . $program->title . ' - Stereo Umachiri 98.5 FM')
@section('description', 'Escucha los episodios y podcasts de ' . $program->title . ' en Stereo Umachiri 98.5 FM.')

@section('content')

{{-- ── PROGRAM HERO ── --}}
<div class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);">
    {{-- Bg image with subtle overlay --}}
    @if($program->image)
        <div style="position: absolute; inset: 0; z-index: 0;">
            <img src="{{ asset('storage/'.$program->image) }}" alt="{{ $program->title }}"
                 style="width: 100%; height: 100%; object-fit: cover; opacity: 0.15; filter: blur(4px);">
        </div>
    @endif
    <div style="position: absolute; right: -5%; top: -40%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(245,158,11,0.18), transparent 70%); pointer-events: none; z-index: 0;"></div>

    <div class="container position-relative py-3" style="z-index: 1;">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.programs.index') }}" class="text-white-50 text-decoration-none hover-primary">Programación</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($program->title, 40) }}</li>
            </ol>
        </nav>

        <div class="row align-items-center g-4">
            {{-- Program cover --}}
            <div class="col-md-3 col-lg-2">
                <div class="rounded-4 overflow-hidden shadow-lg border border-white border-opacity-10 position-relative" style="aspect-ratio: 1; background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    @if($program->image)
                        <img src="{{ asset('storage/'.$program->image) }}" alt="{{ $program->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-microphone fa-3x text-white opacity-60"></i>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="col-md-9 col-lg-10">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="width: 8px; height: 8px; background: #f59e0b; border-radius: 50%; display: inline-block; animation: pulse-dot 1.5s infinite;"></span>
                    <span class="text-white-50 small fw-bold tracking-wider">PROGRAMA RADIAL · STEREO UMACHIRI</span>
                </div>
                <h1 class="text-white fw-black mb-3" style="font-size: clamp(1.8rem, 4vw, 2.6rem); line-height: 1.2; letter-spacing: -0.03em;">{{ $program->title }}</h1>
                @if($program->description)
                    <p class="text-white-50 mb-3" style="font-size: 0.95rem; max-width: 720px; line-height: 1.6;">{{ $program->description }}</p>
                @endif
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill py-2 px-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); color: white; font-weight: 600; border: 1px solid rgba(255,255,255,0.15);">
                        <i class="fas fa-user me-1 text-warning"></i> {{ $program->host }}
                    </span>
                    <span class="badge rounded-pill py-2 px-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); color: white; font-weight: 600; border: 1px solid rgba(255,255,255,0.15);">
                        <i class="far fa-clock me-1 text-warning"></i> {{ $program->start_time }} – {{ $program->end_time }}
                    </span>
                    <span class="badge rounded-pill py-2 px-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); color: white; font-weight: 600; border: 1px solid rgba(255,255,255,0.15);">
                        <i class="fas fa-calendar me-1 text-warning"></i> {{ is_array($program->days_of_week) ? implode(', ', $program->days_of_week) : $program->days_of_week }}
                    </span>
                    <span class="badge rounded-pill py-2 px-3" style="background: rgba(245,158,11,0.2); color: #fbbf24; font-weight: 700; border: 1px solid rgba(245,158,11,0.3);">
                        <i class="fas fa-podcast me-1"></i> {{ $podcasts->total() }} episodios
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── PODCASTS LIST ── --}}
<section style="background: var(--bg-body, #f8fafc); padding: 3rem 0 4rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h2 class="fw-bold mb-0" style="color: var(--text-main, #0f172a); font-size: 1.35rem;">
                        <i class="fas fa-headphones me-2 text-primary"></i>Episodios disponibles
                    </h2>
                    <a href="{{ route('public.programs.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Ver programación
                    </a>
                </div>

                @forelse($podcasts as $index => $podcast)
                    <div class="podcast-episode bg-white rounded-4 mb-3 overflow-hidden shadow-sm" style="border: 1px solid rgba(0,0,0,0.06); transition: all 0.25s ease;">
                        <div class="p-3 p-md-4">
                            <div class="d-flex align-items-start gap-3">
                                {{-- Episode number --}}
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 shadow-sm"
                                     style="width: 48px; height: 48px; background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                                    <span class="text-white fw-black" style="font-size: 0.95rem;">
                                        {{ $podcasts->currentPage() > 1 ? ($podcasts->currentPage()-1)*$podcasts->perPage()+$index+1 : $index+1 }}
                                    </span>
                                </div>
                                {{-- Info --}}
                                <div class="flex-fill overflow-hidden">
                                    <h3 class="fw-bold mb-1" style="color: var(--text-main, #0f172a); font-size: 1.05rem; line-height: 1.35;">{{ $podcast->title }}</h3>
                                    @if($podcast->description)
                                        <p class="text-muted mb-2" style="font-size: 0.86rem; line-height: 1.5;">{{ Str::limit($podcast->description, 130) }}</p>
                                    @endif
                                    <small class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $podcast->created_at->diffForHumans() }}</small>
                                </div>
                            </div>

                            {{-- Audio player --}}
                            @if($podcast->audio_path)
                                <div class="mt-3 p-2 rounded-3" style="background: rgba(30, 58, 138, 0.04);">
                                    <audio controls class="w-100 rounded-3" style="height: 42px; accent-color: #1e3a8a;">
                                        <source src="{{ asset('storage/'.$podcast->audio_path) }}" type="audio/mpeg">
                                        Tu navegador no soporta el elemento de audio.
                                    </audio>
                                </div>
                            @else
                                <div class="mt-3 rounded-3 p-3 d-flex align-items-center gap-2"
                                     style="background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);">
                                    <i class="fas fa-exclamation-triangle" style="color: #d97706;"></i>
                                    <small style="color: #92400e;">Audio no disponible temporalmente.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4" style="border: 1px solid rgba(0,0,0,0.06);">
                        <i class="fas fa-podcast fa-3x text-muted mb-3 opacity-50"></i>
                        <h5 class="fw-bold text-dark">Este programa aún no tiene episodios subidos.</h5>
                        <p class="text-muted small">Pronto añadiremos grabaciones y podcasts de este espacio.</p>
                        <a href="{{ route('public.programs.index') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Programación
                        </a>
                    </div>
                @endforelse

                @if($podcasts->count() > 0)
                    <div class="mt-4">
                        {{ $podcasts->links() }}
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('public.programs.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Volver a la Programación
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.podcast-episode').forEach(c => {
    c.addEventListener('mouseenter', () => {
        c.style.boxShadow = '0 12px 30px rgba(30, 58, 138, 0.12)';
        c.style.transform = 'translateY(-3px)';
    });
    c.addEventListener('mouseleave', () => {
        c.style.boxShadow = '';
        c.style.transform = '';
    });
});
</script>
<style>
@keyframes pulse-dot { 0%,100%{opacity:1;transform:scale(1);} 50%{opacity:0.4;transform:scale(0.8);} }
</style>
@endpush

@endsection
