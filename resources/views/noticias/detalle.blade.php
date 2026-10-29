@extends('layouts.app')

@section('title', $noticia->title . ' - Stereo Umachiri 98.5 FM')
@section('description', Str::limit(strip_tags($noticia->content), 160))

@section('content')

{{-- ── ARTICLE HERO ── --}}
<div class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #172554 100%);">
    <div style="position: absolute; right: -5%; top: -40%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(245,158,11,0.15), transparent 70%); pointer-events: none;"></div>

    <div class="container position-relative py-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" class="text-white-50 text-decoration-none hover-primary">Noticias</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($noticia->title, 40) }}</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="badge rounded-pill px-3 py-1" style="background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); font-weight: 700; font-size: 0.75rem;">
                {{ ucfirst($noticia->type) }}
            </span>
            <span class="text-white-50 small">
                <i class="far fa-clock me-1 text-warning"></i>{{ $noticia->published_at ? $noticia->published_at->format('d/m/Y H:i') : $noticia->created_at->format('d/m/Y') }}
            </span>
        </div>

        <h1 class="text-white fw-black mb-3" style="font-size: clamp(1.8rem, 4vw, 2.7rem); line-height: 1.25; max-width: 900px; letter-spacing: -0.03em;">
            {{ $noticia->title }}
        </h1>

        <div class="d-flex align-items-center gap-3 text-white-50 small">
            <span><i class="fas fa-user-circle me-1 text-warning"></i>{{ $noticia->author ?? 'Redacción Stereo Umachiri' }}</span>
            <span>·</span>
            <span><i class="fas fa-map-marker-alt me-1 text-danger"></i>Umachiri, Melgar - Puno</span>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background: var(--bg-body, #f8fafc); padding: 3rem 0 4rem;">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Main Column --}}
            <div class="col-lg-8">
                <article class="bg-white rounded-4 p-4 p-md-5 shadow-sm mb-4" style="border: 1px solid rgba(0,0,0,0.06);">
                    {{-- Featured Image --}}
                    @if($noticia->image)
                        <figure class="mb-4 rounded-4 overflow-hidden shadow-sm" style="max-height: 480px; background: #0f172a;">
                            <img src="{{ asset('storage/' . $noticia->image) }}"
                                 alt="{{ $noticia->title }}"
                                 class="img-fluid w-100"
                                 style="max-height: 480px; object-fit: cover;">
                        </figure>
                    @endif

                    {{-- Body Text --}}
                    <div class="article-content" style="font-size: 1.1rem; line-height: 1.85; color: #334155;">
                        {!! nl2br(e($noticia->content)) !!}
                    </div>

                    {{-- Share Bar --}}
                    <div class="mt-5 pt-4 border-top border-light d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted small fw-bold">Compartir:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold text-white shadow-sm"
                               style="background: #1877f2;"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($noticia->title . ' ' . request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold text-white shadow-sm"
                               style="background: #25d366;"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($noticia->title) }}&url={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold text-white shadow-sm"
                               style="background: #0f172a;"><i class="fab fa-x-twitter me-1"></i>X</a>
                        </div>

                        <a href="{{ route('noticias.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Volver a noticias
                        </a>
                    </div>
                </article>

                {{-- Comments Section --}}
                <div class="bg-white rounded-4 p-4 p-md-5 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom border-light">
                        <h3 class="h5 fw-bold mb-0" style="color: var(--text-main, #0f172a);">
                            <i class="fas fa-comments text-primary me-2"></i>Comentarios
                            <span class="badge rounded-pill ms-2" style="background: rgba(30,58,138,0.1); color: #1e3a8a; font-size: 0.8rem;">
                                {{ $comments->where('approved', 1)->count() }}
                            </span>
                        </h3>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success rounded-3 mb-4 d-flex align-items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    {{-- Comment Form --}}
                    <form action="{{ route('noticias.comments.store', $noticia->id) }}" method="POST" class="mb-4 p-4 rounded-4" style="background: rgba(30,58,138,0.03); border: 1px solid rgba(30,58,138,0.08);">
                        @csrf
                        <h5 class="fw-bold mb-3 small text-uppercase tracking-wider" style="color: #1e3a8a;">
                            <i class="fas fa-pencil-alt me-1"></i>Deja tu opinión
                        </h5>
                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold text-dark">Tu Nombre / Pseudónimo *</label>
                            <input type="text" name="name" id="name" class="form-control rounded-3" placeholder="Ej: Juan Pérez" value="{{ old('name') }}" required>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label small fw-bold text-dark">Tu Comentario *</label>
                            <textarea name="content" id="content" rows="3" class="form-control rounded-3" placeholder="Escribe tu mensaje con respeto a la comunidad..." required>{{ old('content') }}</textarea>
                            @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                            <i class="fas fa-paper-plane me-1"></i> Publicar comentario
                        </button>
                    </form>

                    {{-- Approved Comments List --}}
                    <div class="comments-list">
                        @forelse($comments->where('approved', 1) as $comment)
                            <div class="p-3 mb-3 rounded-3" style="background: #f8fafc; border-left: 3px solid #1e3a8a;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold text-dark small"><i class="fas fa-user-circle text-primary me-1"></i>{{ $comment->name }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: 0.92rem; line-height: 1.5;">{{ $comment->content }}</p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-comment-dots fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0 small">Aún no hay comentarios en esta noticia. ¡Sé el primero en opinar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Radio CTA --}}
                <div class="rounded-4 p-4 mb-4 text-center text-white shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                    <div style="position: absolute; right: -20px; top: -20px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(245,158,11,0.25), transparent 70%); pointer-events: none;"></div>
                    <i class="fas fa-tower-broadcast fa-2x text-warning mb-2"></i>
                    <h5 class="fw-bold mb-1">Stereo Umachiri 98.5 FM</h5>
                    <p class="small text-white-50 mb-3">La radio informativa de Melgar, Puno</p>
                    <a href="{{ url('/') }}#player" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm" style="color: #0f172a;">
                        <i class="fas fa-play me-1"></i> Escuchar en vivo
                    </a>
                </div>

                {{-- Related News --}}
                @if(isset($relatedNoticias) && $relatedNoticias->count() > 0)
                    <div class="bg-white rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(0,0,0,0.06);">
                        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: var(--text-main, #0f172a);">
                            <i class="fas fa-bolt text-warning"></i> Más noticias
                        </h6>
                        @foreach($relatedNoticias as $related)
                            <a href="{{ route('noticias.show', $related->id) }}" class="text-decoration-none d-flex gap-3 mb-3 pb-3 border-bottom border-light recent-item" style="transition: all 0.2s ease;">
                                @if($related->image)
                                    <div style="width: 60px; height: 60px; min-width: 60px; border-radius: 10px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                @else
                                    <div style="width: 60px; height: 60px; min-width: 60px; border-radius: 10px; background: linear-gradient(135deg, #1e3a8a, #2563eb); display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-newspaper text-white" style="font-size: 0.9rem;"></i>
                                    </div>
                                @endif
                                <div class="flex-fill">
                                    <div class="text-dark fw-bold" style="font-size: 0.85rem; line-height: 1.35;">{{ Str::limit($related->title, 55) }}</div>
                                    <small class="text-muted"><i class="far fa-clock me-1 text-primary"></i>{{ $related->published_at ? $related->published_at->diffForHumans() : $related->created_at->diffForHumans() }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.recent-item').forEach(c => {
    c.addEventListener('mouseenter', () => { c.style.paddingLeft = '6px'; });
    c.addEventListener('mouseleave', () => { c.style.paddingLeft = ''; });
});
</script>
@endpush

@endsection