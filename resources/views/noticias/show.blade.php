@extends('layouts.app')

@section('title', $news->title . ' - Stereo Umachiri')
@section('description', Str::limit(strip_tags($news->content), 160))

@section('content')

{{-- ── ARTICLE HERO ── --}}
<div style="position:relative;overflow:hidden;min-height:280px;background:#0d2a1a;display:flex;align-items:flex-end;">
    @if($news->image)
        <div style="position:absolute;inset:0;z-index:0;">
            <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}"
                 style="width:100%;height:100%;object-fit:cover;opacity:0.22;">
        </div>
    @endif
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(13,42,26,1) 0%,rgba(13,42,26,0.55) 60%,transparent 100%);z-index:1;"></div>
    <div class="container position-relative pb-4 pt-5" style="z-index:2;">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.82rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" class="text-white-50 text-decoration-none">Noticias</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($news->title, 40) }}</li>
            </ol>
        </nav>
        <span class="badge mb-2 rounded-pill" style="background:rgba(21,128,61,0.2);color:#22c55e;border:1px solid rgba(34,197,94,0.3);font-weight:700;">{{ ucfirst($news->type) }}</span>
        <h1 class="text-white fw-black mb-2" style="font-size:clamp(1.5rem,4vw,2.4rem);line-height:1.2;max-width:820px;">{{ $news->title }}</h1>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <small class="text-white-50"><i class="fas fa-user me-1"></i>{{ $news->author }}</small>
            <small class="text-white-50"><i class="far fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($news->published_at)->format('d/m/Y') }}</small>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background:#f7f7f5;padding:2.5rem 0 3rem;">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Article --}}
            <div class="col-lg-8">
                <article class="bg-white rounded-4 p-4 p-md-5" style="border:1px solid rgba(0,0,0,0.07);">
                    @if($news->image)
                        <figure class="mb-4 rounded-4 overflow-hidden" style="max-height:460px;">
                            <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}"
                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                        </figure>
                    @endif

                    <div class="article-content" style="font-size:1.08rem;line-height:1.9;color:#374151;">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    {{-- Share --}}
                    <div class="mt-5 pt-4" style="border-top:1px solid rgba(0,0,0,0.08);">
                        <p class="text-muted small fw-semibold mb-3">Compartir esta noticia:</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#1877f2;color:white;"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#000;color:white;"><i class="fab fa-x-twitter me-1"></i>Twitter/X</a>
                            <a href="https://wa.me/?text={{ urlencode($news->title.' '.request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#25d366;color:white;"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                            <a href="{{ route('noticias.index') }}"
                               class="btn btn-sm rounded-pill px-3 btn-outline-secondary ms-auto">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                </article>

                {{-- Comments --}}
                <div class="bg-white rounded-4 p-4 p-md-5 mt-4" style="border:1px solid rgba(0,0,0,0.07);">
                    <h4 class="fw-bold mb-4" style="color:#0d2a1a;font-size:1.1rem;">
                        <i class="fas fa-comment-dots me-2" style="color:#15803d;"></i>Deja tu comentario
                    </h4>

                    @if(session('success'))
                        <div class="alert rounded-3 mb-4 d-flex align-items-center gap-2"
                             style="background:rgba(21,128,61,0.08);border:1px solid rgba(21,128,61,0.2);color:#15803d;">
                            <i class="fas fa-check-circle"></i><span>Tu comentario fue enviado. Será visible tras aprobación.</span>
                        </div>
                    @endif

                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="news_id" value="{{ $news->id }}">
                        <div class="mb-3">
                            <textarea name="content" rows="4"
                                      class="form-control rounded-3 @error('content') is-invalid @enderror"
                                      placeholder="Escribe tu comentario aquí... (máx. 500 caracteres)"
                                      required maxlength="500"
                                      style="border:1px solid rgba(0,0,0,0.12);resize:none;font-size:0.95rem;">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <small class="text-muted">Tu comentario será visible tras aprobación.</small>
                            <button type="submit" class="btn rounded-pill px-4 fw-bold"
                                    style="background:linear-gradient(135deg,#15803d,#166534);color:white;border:none;">
                                <i class="fas fa-paper-plane me-2"></i>Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Related News --}}
                @if($relatedNews->count() > 0)
                    <div class="bg-white rounded-4 overflow-hidden mb-3" style="border:1px solid rgba(0,0,0,0.07);position:sticky;top:80px;">
                        <div class="p-3" style="background:linear-gradient(135deg,#0d2a1a,#15803d);">
                            <h6 class="text-white fw-bold mb-0"><i class="fas fa-newspaper me-2"></i>Noticias Relacionadas</h6>
                        </div>
                        <div class="p-3">
                            @foreach($relatedNews as $related)
                                <a href="{{ route('noticias.show', $related->id) }}"
                                   class="text-decoration-none d-flex gap-2 mb-3 related-item" style="transition:all 0.2s ease;">
                                    @if($related->image)
                                        <div style="width:64px;height:64px;min-width:64px;border-radius:8px;overflow:hidden;">
                                            <img src="{{ asset('storage/'.$related->image) }}" alt="{{ $related->title }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div style="width:64px;height:64px;min-width:64px;border-radius:8px;background:linear-gradient(135deg,#15803d,#22c55e);display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-newspaper text-white" style="font-size:0.9rem;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-dark fw-semibold" style="font-size:0.83rem;line-height:1.3;">{{ Str::limit($related->title, 55) }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($related->published_at)->format('d/m/Y') }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Radio CTA --}}
                <div class="rounded-4 p-4 text-center text-white" style="background:linear-gradient(135deg,#15803d,#064e3b);">
                    <i class="fas fa-broadcast-tower fa-2x mb-2 opacity-75"></i>
                    <h6 class="fw-bold mb-1">Escúchanos en vivo</h6>
                    <p class="small opacity-75 mb-3">98.5 FM · 24 horas al día</p>
                    <a href="{{ url('/') }}" class="btn btn-sm btn-light rounded-pill px-4 fw-bold" style="color:#15803d;">
                        <i class="fas fa-play me-1"></i> EN VIVO
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.article-content p { margin-bottom: 1.5rem; }
.article-content h2, .article-content h3 { color: #0d2a1a; font-weight: 700; margin: 2rem 0 1rem; }
</style>

@push('scripts')
<script>
document.querySelectorAll('.related-item').forEach(c => {
    c.addEventListener('mouseenter', () => { c.style.paddingLeft = '6px'; });
    c.addEventListener('mouseleave', () => { c.style.paddingLeft = ''; });
});
</script>
@endpush

@endsection