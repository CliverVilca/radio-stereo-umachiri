@extends('layouts.app')

@section('title', 'Galería de Fotos - Stereo Umachiri 98.5 FM')
@section('description', 'Fotografías y momentos especiales de transmisiones, eventos y fiestas patronales en Umachiri y Melgar.')

@section('content')

{{-- ── PAGE HERO ── --}}
<div class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);">
    <div style="position: absolute; left: -5%; top: -30%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; right: 5%; bottom: -40%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(245,158,11,0.18), transparent 70%); pointer-events: none;"></div>

    <div class="container position-relative py-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Galería</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-4 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-camera-retro text-white fa-xl"></i>
            </div>
            <div>
                <span class="badge rounded-pill px-3 py-1 mb-1" style="background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); font-weight: 700; font-size: 0.72rem;">
                    REGISTRO VISUAL
                </span>
                <h1 class="text-white fw-black mb-1" style="font-size: clamp(1.8rem, 3.5vw, 2.5rem); letter-spacing: -0.03em;">Galería de Fotos</h1>
                <p class="text-white-50 mb-0 small">Momentos inolvidables capturados en el altiplano puneño junto a nuestra gente</p>
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background: #0b1120; padding: 3rem 0 4.5rem;">
    <div class="container">
        @if($galleries->count() > 0)
            <div class="row g-3">
                @foreach($galleries as $index => $gallery)
                    {{-- Every 7th starts a new "feature" cycle: first is wider --}}
                    <div class="{{ $index % 7 === 0 || $index % 7 === 6 ? 'col-md-8' : 'col-md-4' }} col-12">
                        <a href="{{ route('public.galleries.show', $gallery->id) }}" class="text-decoration-none d-block">
                            <div class="gallery-card position-relative rounded-4 overflow-hidden shadow-lg"
                                 style="height: {{ $index % 7 === 0 || $index % 7 === 6 ? '300px' : '220px' }}; background: #1e293b; border: 1px solid rgba(255,255,255,0.08);">
                                @if($gallery->images && count($gallery->images) > 0)
                                    <img src="{{ asset('storage/'.$gallery->images[0]) }}"
                                         alt="{{ $gallery->title }}"
                                         class="gallery-card-img"
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); display: block;">
                                @else
                                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e3a8a, #3b82f6); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-images text-white opacity-40 fa-3x"></i>
                                    </div>
                                @endif

                                {{-- Overlay --}}
                                <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4"
                                     style="background: linear-gradient(to top, rgba(15,23,42,0.92) 0%, rgba(15,23,42,0.4) 50%, transparent 80%); opacity: 0; transition: opacity 0.35s ease;">
                                    <h3 class="text-white fw-bold mb-1" style="font-size: 1.05rem; line-height: 1.35;">{{ $gallery->title }}</h3>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($gallery->images)
                                            <small style="color: rgba(255,255,255,0.75);"><i class="fas fa-images me-1 text-warning"></i>{{ count($gallery->images) }} fotografías</small>
                                        @endif
                                        @if($gallery->is_featured)
                                            <span class="badge ms-auto" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; font-size: 0.68rem; font-weight: 800;"><i class="fas fa-star me-1"></i>Destacada</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Photo count pill (always visible) --}}
                                @if($gallery->images && count($gallery->images) > 0)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(15,23,42,0.75); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); font-size: 0.72rem; color: #fff;">
                                            <i class="fas fa-camera me-1 text-warning"></i>{{ count($gallery->images) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $galleries->links() }}
            </div>
        @else
            <div class="text-center py-5 text-white-50">
                <i class="fas fa-photo-video fa-3x mb-3 opacity-40"></i>
                <h5>No hay álbumes o galerías disponibles aún.</h5>
                <p class="small">Pronto compartiremos coberturas fotográficas de nuestras actividades.</p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.gallery-card').forEach(el => {
    const img = el.querySelector('.gallery-card-img');
    const overlay = el.querySelector('.gallery-overlay');
    el.addEventListener('mouseenter', () => {
        if(img) img.style.transform = 'scale(1.08)';
        if(overlay) overlay.style.opacity = '1';
    });
    el.addEventListener('mouseleave', () => {
        if(img) img.style.transform = 'scale(1)';
        if(overlay) overlay.style.opacity = '0';
    });
});
</script>
@endpush

@endsection