@extends('layouts.app')

@section('title', $sport->title . ' - Deportes - Stereo Umachiri')
@section('description', Str::limit(strip_tags($sport->content), 160))

@section('content')

{{-- ── ARTICLE HERO ── --}}
<div style="position:relative;overflow:hidden;min-height:280px;background:#1a0a00;display:flex;align-items:flex-end;">
    @if($sport->image)
        <div style="position:absolute;inset:0;z-index:0;">
            <img src="{{ asset('storage/'.$sport->image) }}" alt="{{ $sport->title }}"
                 style="width:100%;height:100%;object-fit:cover;opacity:0.3;">
        </div>
    @endif
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(26,10,0,1) 0%,rgba(26,10,0,0.5) 60%,transparent 100%);z-index:1;"></div>
    <div class="container position-relative pb-4 pt-5" style="z-index:2;">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.82rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.sports.index') }}" class="text-white-50 text-decoration-none">Deportes</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($sport->title, 40) }}</li>
            </ol>
        </nav>
        <span class="badge mb-2" style="background:#f59e0b;color:#1a1a1a;font-weight:700;"><i class="fas fa-trophy me-1"></i>Deportes</span>
        <h1 class="text-white fw-black mb-2" style="font-size:clamp(1.4rem,3.5vw,2.2rem);line-height:1.2;max-width:800px;">{{ $sport->title }}</h1>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            @if($sport->author)
                <small class="text-white-50"><i class="fas fa-user me-1"></i>{{ $sport->author }}</small>
            @endif
            <small class="text-white-50"><i class="far fa-clock me-1"></i>{{ $sport->published_at ? $sport->published_at->diffForHumans() : $sport->created_at->diffForHumans() }}</small>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background:#f7f7f5;padding:2.5rem 0 3rem;">
    <div class="container">
        <div class="row g-4">

            {{-- Article --}}
            <div class="col-lg-8">
                <article class="bg-white rounded-4 p-4 p-md-5" style="border:1px solid rgba(0,0,0,0.07);">
                    @if($sport->image)
                        <figure class="mb-4 rounded-4 overflow-hidden" style="max-height:420px;">
                            <img src="{{ asset('storage/'.$sport->image) }}" alt="{{ $sport->title }}"
                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                        </figure>
                    @endif

                    <div class="article-body" style="font-size:1.05rem;line-height:1.85;color:#374151;">
                        {!! $sport->content !!}
                    </div>

                    {{-- Share --}}
                    <div class="mt-4 pt-4" style="border-top:1px solid rgba(0,0,0,0.08);">
                        <p class="text-muted small fw-semibold mb-2">Compartir esta noticia:</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#1877f2;color:white;"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                            <a href="https://wa.me/?text={{ urlencode($sport->title.' '.request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#25d366;color:white;"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                            <a href="{{ route('public.sports.index') }}"
                               class="btn btn-sm rounded-pill px-3 btn-outline-secondary ms-auto">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                @if($relatedSports->count() > 0)
                    <div class="bg-white rounded-4 overflow-hidden" style="border:1px solid rgba(0,0,0,0.07);">
                        <div class="p-3" style="background:linear-gradient(135deg,#78350f,#d97706);">
                            <h6 class="text-white fw-bold mb-0"><i class="fas fa-trophy me-2"></i>Más Deportes</h6>
                        </div>
                        <div class="p-3">
                            @foreach($relatedSports as $rel)
                                <a href="{{ route('public.sports.show', $rel->id) }}"
                                   class="text-decoration-none d-flex gap-2 mb-3 related-sport" style="transition:all 0.2s ease;">
                                    @if($rel->image)
                                        <div style="width:64px;height:64px;min-width:64px;border-radius:8px;overflow:hidden;">
                                            <img src="{{ asset('storage/'.$rel->image) }}" alt="{{ $rel->title }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div style="width:64px;height:64px;min-width:64px;border-radius:8px;background:linear-gradient(135deg,#d97706,#f59e0b);display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-futbol text-white" style="font-size:1.2rem;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-dark fw-semibold" style="font-size:0.83rem;line-height:1.3;">{{ Str::limit($rel->title, 55) }}</div>
                                        <small class="text-muted">{{ $rel->published_at ? $rel->published_at->diffForHumans() : $rel->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<style>
.article-body p { margin-bottom: 1.4rem; }
.article-body h2, .article-body h3 { color: #0d2a1a; font-weight: 700; margin: 2rem 0 1rem; }
.article-body img { max-width: 100%; border-radius: 12px; margin: 1rem 0; }
</style>

@push('scripts')
<script>
document.querySelectorAll('.related-sport').forEach(c => {
    c.addEventListener('mouseenter', () => { c.style.paddingLeft = '6px'; });
    c.addEventListener('mouseleave', () => { c.style.paddingLeft = ''; });
});
</script>
@endpush

@endsection