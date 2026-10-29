@extends('layouts.app')

@section('title', 'Deportes - Stereo Umachiri 98.5 FM')
@section('description', 'Las últimas noticias y resultados deportivos de Melgar y la región Puno.')

@section('content')

{{-- ── PAGE HERO ── --}}
<div style="background:linear-gradient(135deg,#78350f 0%,#d97706 100%);padding:3rem 0 2rem;position:relative;overflow:hidden;">
    <div style="position:absolute;right:-5%;top:-50%;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,0.06),transparent 70%);pointer-events:none;"></div>
    <div class="container position-relative">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.82rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item active text-white">Deportes</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:52px;height:52px;background:rgba(255,255,255,0.12);">
                <i class="fas fa-trophy text-white fa-lg"></i>
            </div>
            <div>
                <h1 class="text-white fw-black mb-0" style="font-size:2rem;">Deportes</h1>
                <p class="text-white-50 mb-0 small">Noticias deportivas de Melgar y la región</p>
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background:#f7f7f5;padding:2.5rem 0 3rem;">
    <div class="container">

        @if($sports->count() > 0)
            {{-- Featured (first item) --}}
            @php $featured = $sports->first(); $rest = $sports->skip(1); @endphp
            <a href="{{ route('public.sports.show', $featured->id) }}" class="text-decoration-none d-block mb-4">
                <article class="position-relative rounded-4 overflow-hidden sport-hero" style="height:380px;background:#1a1a1a;">
                    @if($featured->image)
                        <img src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}"
                             class="sport-hero-img"
                             style="width:100%;height:100%;object-fit:cover;opacity:0.65;transition:transform 0.5s ease;display:block;">
                    @else
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#78350f,#d97706);"></div>
                    @endif
                    <div class="position-absolute inset-0 top-0 start-0 end-0 bottom-0 p-4 d-flex flex-column justify-content-end"
                         style="background:linear-gradient(to top,rgba(0,0,0,0.9) 0%,transparent 60%);">
                        <span class="badge mb-2" style="background:#f59e0b;color:#1a1a1a;font-weight:800;width:fit-content;"><i class="fas fa-star me-1"></i> DESTACADO</span>
                        <h2 class="text-white fw-black mb-2" style="font-size:1.6rem;line-height:1.3;">{{ $featured->title }}</h2>
                        <div class="d-flex align-items-center gap-3">
                            <small class="text-white-50"><i class="far fa-clock me-1"></i>{{ $featured->published_at ? $featured->published_at->diffForHumans() : $featured->created_at->diffForHumans() }}</small>
                            <span class="text-white fw-semibold ms-auto small">Leer más <i class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </article>
            </a>

            {{-- Grid --}}
            <div class="row g-3">
                @foreach($rest as $sport)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('public.sports.show', $sport->id) }}" class="text-decoration-none d-block h-100">
                            <article class="sport-card bg-white rounded-4 overflow-hidden h-100" style="border:1px solid rgba(0,0,0,0.07);transition:all 0.25s ease;">
                                <div style="height:180px;overflow:hidden;background:#e5e7eb;">
                                    @if($sport->image)
                                        <img src="{{ asset('storage/'.$sport->image) }}" alt="{{ $sport->title }}"
                                             class="sport-card-img"
                                             style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;">
                                    @else
                                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#d97706,#f59e0b);display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-futbol fa-2x text-white opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge rounded-pill" style="background:rgba(245,158,11,0.1);color:#d97706;font-size:0.7rem;font-weight:700;"><i class="fas fa-trophy me-1"></i>Deportes</span>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $sport->published_at ? $sport->published_at->diffForHumans() : $sport->created_at->diffForHumans() }}</small>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0" style="line-height:1.35;">{{ Str::limit($sport->title, 75) }}</h6>
                                </div>
                            </article>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $sports->links() }}
            </div>

        @else
            <div class="text-center py-5">
                <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay noticias deportivas disponibles aún.</h5>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
const hero = document.querySelector('.sport-hero');
const heroImg = hero?.querySelector('.sport-hero-img');
if(hero) {
    hero.addEventListener('mouseenter', () => { if(heroImg) heroImg.style.transform='scale(1.04)'; hero.style.boxShadow='0 20px 60px rgba(0,0,0,0.35)'; });
    hero.addEventListener('mouseleave', () => { if(heroImg) heroImg.style.transform='scale(1)'; hero.style.boxShadow=''; });
}
document.querySelectorAll('.sport-card').forEach(c => {
    const img = c.querySelector('.sport-card-img');
    c.addEventListener('mouseenter', () => { c.style.transform='translateY(-4px)'; c.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'; if(img) img.style.transform='scale(1.06)'; });
    c.addEventListener('mouseleave', () => { c.style.transform=''; c.style.boxShadow=''; if(img) img.style.transform=''; });
});
</script>
@endpush

@endsection
