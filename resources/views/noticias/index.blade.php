@extends('layouts.app')

@section('title', 'Noticias - Stereo Umachiri 98.5 FM')
@section('description', 'Últimas noticias de Melgar, Puno, el Perú y el mundo. Periodismo con identidad y veracidad desde Stereo Umachiri 98.5 FM.')

@section('content')

{{-- ── PAGE HERO ── --}}
<div class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);">
    <div style="position: absolute; right: -5%; top: -50%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(245,158,11,0.18), transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; left: -10%; bottom: -40%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%); pointer-events: none;"></div>

    <div class="container position-relative py-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Noticias</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-4 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-newspaper text-white fa-xl"></i>
            </div>
            <div>
                <span class="badge rounded-pill px-3 py-1 mb-1" style="background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); font-weight: 700; font-size: 0.72rem;">
                    INFORMACIÓN VERAZ
                </span>
                <h1 class="text-white fw-black mb-1" style="font-size: clamp(1.8rem, 3.5vw, 2.5rem); letter-spacing: -0.03em;">Actualidad & Noticias</h1>
                <p class="text-white-50 mb-0 small">Cobertura informativa desde Umachiri, la provincia de Melgar y la región Puno</p>
            </div>
        </div>
    </div>
</div>

{{-- ── FILTER BAR ── --}}
<div class="py-2" style="background: var(--bg-card, #ffffff); border-bottom: 1px solid rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 100; backdrop-filter: blur(12px);">
    <div class="container">
        <div class="d-flex gap-2 py-1 overflow-auto align-items-center" style="scrollbar-width: none;">
            <a href="{{ route('noticias.index') }}"
               class="btn btn-sm rounded-pill flex-shrink-0 px-3 {{ !request('type') ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }}"
               style="font-weight: 700; font-size: 0.82rem;">
               <i class="fas fa-layer-group me-1"></i> Todas
            </a>
            @foreach(['local' => 'Local / Melgar', 'regional' => 'Regional / Puno', 'nacional' => 'Nacional', 'internacional' => 'Internacional'] as $tipoKey => $tipoLabel)
                <a href="{{ route('noticias.index', ['type' => $tipoKey]) }}"
                   class="btn btn-sm rounded-pill flex-shrink-0 px-3 {{ request('type') == $tipoKey ? 'btn-primary shadow-sm' : 'btn-outline-secondary' }}"
                   style="font-weight: 600; font-size: 0.82rem;">
                   {{ $tipoLabel }}
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background: var(--bg-body, #f8fafc); padding: 2.5rem 0 4rem;">
    <div class="container">
        <div class="row g-4">

            {{-- Articles Column --}}
            <div class="col-lg-8">
                @forelse($noticias as $noticia)
                    <a href="{{ route('noticias.show', $noticia->id) }}" class="text-decoration-none d-block mb-3">
                        <article class="news-row-card bg-white rounded-4 overflow-hidden d-flex shadow-sm" style="border: 1px solid rgba(0,0,0,0.06); transition: all 0.28s ease;">
                            {{-- Thumbnail --}}
                            <div style="width: 220px; min-width: 220px; max-width: 220px; background: #0f172a; overflow: hidden; position: relative;" class="d-none d-sm-block">
                                @if($noticia->image)
                                    <img src="{{ asset('storage/' . $noticia->image) }}" alt="{{ $noticia->title }}"
                                         class="news-row-img"
                                         style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease;">
                                @else
                                    <div style="width: 100%; height: 100%; min-height: 150px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-newspaper fa-2x text-white opacity-50"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-3 p-md-4 d-flex flex-column justify-content-between flex-fill">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(30,58,138,0.1); color: #1e3a8a; font-size: 0.72rem; font-weight: 700;">
                                            {{ ucfirst($noticia->type) }}
                                        </span>
                                        <small class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $noticia->published_at ? $noticia->published_at->diffForHumans() : $noticia->created_at->diffForHumans() }}</small>
                                    </div>
                                    <h2 class="fw-bold mb-2 text-dark" style="font-size: 1.12rem; line-height: 1.35;">{{ $noticia->title }}</h2>
                                    <p class="text-muted mb-0 d-none d-md-block" style="font-size: 0.88rem; line-height: 1.55;">{{ Str::limit(strip_tags($noticia->content), 130) }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light">
                                    <small class="text-muted"><i class="fas fa-user-circle me-1 text-primary"></i>{{ $noticia->author ?? 'Redacción' }}</small>
                                    <span class="fw-bold text-primary" style="font-size: 0.84rem;">Leer nota completa <i class="fas fa-arrow-right ms-1 small"></i></span>
                                </div>
                            </div>
                        </article>
                    </a>
                @empty
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4" style="border: 1px solid rgba(0,0,0,0.06);">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3 opacity-50"></i>
                        <h5 class="fw-bold text-dark">No hay noticias en esta sección por el momento.</h5>
                        <a href="{{ route('noticias.index') }}" class="btn btn-sm btn-primary rounded-pill px-4 mt-2">Ver todas las noticias</a>
                    </div>
                @endforelse

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $noticias->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Search --}}
                <div class="bg-white rounded-4 p-3 mb-3 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                    <form method="GET" action="{{ route('noticias.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-start-pill ps-3" placeholder="Buscar noticias..." value="{{ request('search') }}" style="border-right: 0;">
                            <button class="btn btn-primary rounded-end-pill px-3" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                {{-- Categories --}}
                <div class="bg-white rounded-4 p-4 mb-3 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--text-main, #0f172a);">
                        <i class="fas fa-tags text-warning"></i> Secciones
                    </h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['Local' => 'local', 'Regional' => 'regional', 'Nacional' => 'nacional', 'Internacional' => 'internacional', 'Cultura' => 'cultura', 'Economía' => 'economia'] as $catName => $catSlug)
                            <a href="{{ route('noticias.index', ['type' => $catSlug]) }}"
                               class="badge rounded-pill text-decoration-none py-2 px-3 category-pill"
                               style="background: rgba(30,58,138,0.06); color: #1e3a8a; font-size: 0.8rem; font-weight: 600; border: 1px solid rgba(30,58,138,0.12); transition: all 0.2s ease;">
                                {{ $catName }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Latest news --}}
                <div class="bg-white rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--text-main, #0f172a);">
                        <i class="fas fa-bolt text-warning"></i> Lo más reciente
                    </h6>
                    @foreach($noticias->take(5) as $rec)
                        <a href="{{ route('noticias.show', $rec->id) }}" class="text-decoration-none d-flex gap-3 mb-3 pb-3 border-bottom border-light recent-item" style="transition: all 0.2s ease;">
                            @if($rec->image)
                                <div style="width: 60px; height: 60px; min-width: 60px; border-radius: 10px; overflow: hidden;">
                                    <img src="{{ asset('storage/'.$rec->image) }}" alt="{{ $rec->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div style="width: 60px; height: 60px; min-width: 60px; border-radius: 10px; background: linear-gradient(135deg, #1e3a8a, #2563eb); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-newspaper text-white" style="font-size: 0.9rem;"></i>
                                </div>
                            @endif
                            <div class="flex-fill">
                                <div class="text-dark fw-bold" style="font-size: 0.85rem; line-height: 1.35;">{{ Str::limit($rec->title, 55) }}</div>
                                <small class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $rec->published_at ? $rec->published_at->diffForHumans() : $rec->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Radio CTA --}}
                <div class="rounded-4 p-4 mt-4 text-center text-white shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                    <div style="position: absolute; right: -20px; top: -20px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(245,158,11,0.25), transparent 70%); pointer-events: none;"></div>
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-2" style="background: rgba(245,158,11,0.15);">
                        <i class="fas fa-tower-broadcast fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Escúchanos en vivo</h5>
                    <p class="small text-white-50 mb-3">Transmisión online las 24 horas · 98.5 FM Umachiri</p>
                    <a href="{{ url('/') }}#player" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm" style="color: #0f172a;">
                        <i class="fas fa-play me-1"></i> Sintonizar Ahora
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.news-row-card').forEach(c => {
    const img = c.querySelector('.news-row-img');
    c.addEventListener('mouseenter', () => {
        c.style.boxShadow = '0 14px 35px -5px rgba(30, 58, 138, 0.15)';
        c.style.transform = 'translateY(-4px)';
        if(img) img.style.transform = 'scale(1.06)';
    });
    c.addEventListener('mouseleave', () => {
        c.style.boxShadow = '';
        c.style.transform = '';
        if(img) img.style.transform = '';
    });
});
document.querySelectorAll('.recent-item').forEach(c => {
    c.addEventListener('mouseenter', () => { c.style.paddingLeft = '6px'; });
    c.addEventListener('mouseleave', () => { c.style.paddingLeft = ''; });
});
</script>
@endpush

@endsection