@extends('layouts.app')

@section('title', 'Programación - Stereo Umachiri 98.5 FM')
@section('description', 'Conoce la parrilla de programas de Stereo Umachiri 98.5 FM. Música, noticias, cultura y deporte las 24 horas desde Melgar, Puno.')

@section('content')

{{-- ── PAGE HERO ── --}}
<div class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);">
    {{-- Decorative radiant circle --}}
    <div style="position:absolute; right:-5%; top:-40%; width:550px; height:550px; background:radial-gradient(circle, rgba(245,158,11,0.18), rgba(59,130,246,0.08) 60%, transparent 70%); pointer-events:none;"></div>
    <div style="position:absolute; left:-10%; bottom:-50%; width:450px; height:450px; background:radial-gradient(circle, rgba(30,58,138,0.3), transparent 70%); pointer-events:none;"></div>

    <div class="container position-relative py-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Programación</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-4 shadow-sm" style="width:60px; height:60px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-microphone-lines text-white fa-xl"></i>
                </div>
                <div>
                    <span class="badge rounded-pill mb-1 px-3 py-1" style="background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); font-weight: 700; font-size: 0.75rem;">
                        <i class="fas fa-broadcast-tower me-1"></i> 98.5 FM EN VIVO
                    </span>
                    <h1 class="text-white fw-black mb-1" style="font-size: clamp(1.8rem, 3.5vw, 2.6rem); letter-spacing: -0.03em;">Nuestra Programación</h1>
                    <p class="text-white-50 mb-0 small">Parrilla radial completa de lunes a domingo · La voz que te acompaña en el altiplano</p>
                </div>
            </div>

            <a href="{{ url('/') }}#player" class="btn btn-outline-light rounded-pill px-4 py-2 d-inline-flex align-items-center gap-2 fw-semibold" style="backdrop-filter: blur(8px); background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.25);">
                <i class="fas fa-play text-warning"></i> Sintonizar en vivo
            </a>
        </div>

        {{-- Day selector pill tabs --}}
        <div class="day-tabs-wrap p-2 rounded-4" style="background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1);">
            <div class="d-flex gap-2 overflow-auto" style="scrollbar-width: none;">
                @foreach($days as $day)
                    @if($programs[$day]->isNotEmpty())
                        <a href="#day-{{ Str::slug($day) }}"
                           class="btn btn-sm rounded-pill flex-shrink-0 px-3 py-2 day-pill-link"
                           style="background: rgba(255,255,255,0.08); color: white; border: 1px solid rgba(255,255,255,0.15); font-weight: 600; font-size: 0.85rem; transition: all 0.25s ease;">
                            <i class="far fa-calendar me-1 text-warning opacity-75"></i> {{ $day }}
                            <span class="badge rounded-pill ms-1" style="background: rgba(245,158,11,0.25); color: #fbbf24;">{{ $programs[$day]->count() }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background: var(--bg-body, #f8fafc); padding: 3rem 0 4rem;">
    <div class="container">
        @php $hasPrograms = false; @endphp

        @foreach($days as $day)
            @if($programs[$day]->isNotEmpty())
                @php $hasPrograms = true; @endphp
                <div class="mb-5 day-section" id="day-{{ Str::slug($day) }}">
                    {{-- Day Header --}}
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                            <i class="fas fa-calendar-day text-white" style="font-size: 1rem;"></i>
                        </div>
                        <div>
                            <h2 class="fw-black mb-0" style="color: var(--text-main, #0f172a); font-size: 1.45rem;">{{ $day }}</h2>
                            <small class="text-muted">{{ $programs[$day]->count() }} programa(s) programado(s)</small>
                        </div>
                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, rgba(37,99,235,0.25), transparent); border-radius: 99px;"></div>
                    </div>

                    <div class="row g-4">
                        @foreach($programs[$day] as $program)
                            <div class="col-md-6 col-lg-4">
                                <article class="program-card bg-white rounded-4 overflow-hidden h-100 d-flex flex-column shadow-sm" style="border: 1px solid rgba(0,0,0,0.06); transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
                                    {{-- Image & Time Badge --}}
                                    <div style="height: 180px; overflow: hidden; position: relative; background: #0f172a;">
                                        @if($program->image)
                                            <img src="{{ asset('storage/'.$program->image) }}"
                                                 alt="{{ $program->title }}"
                                                 class="program-img"
                                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                        @else
                                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e3a8a 0%, #312e81 60%, #1e1b4b 100%); display: flex; align-items: center; justify-content: center;">
                                                <div class="text-center text-white opacity-60">
                                                    <i class="fas fa-microphone fa-3x mb-2"></i>
                                                    <div class="small fw-bold">Stereo Umachiri</div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="position-absolute inset-0" style="background: linear-gradient(to top, rgba(15,23,42,0.85) 0%, transparent 60%);"></div>

                                        {{-- Time badge --}}
                                        <div class="position-absolute bottom-0 start-0 m-3">
                                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(15,23,42,0.85); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.2); font-size: 0.78rem; font-weight: 700; color: #fff;">
                                                <i class="far fa-clock me-1 text-warning"></i>{{ $program->start_time }} – {{ $program->end_time }}
                                            </span>
                                        </div>

                                        @if($program->is_featured)
                                            <div class="position-absolute top-0 end-0 m-3">
                                                <span class="badge rounded-pill px-3 py-1 shadow" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; font-size: 0.72rem; font-weight: 800;">
                                                    <i class="fas fa-star me-1"></i> Destacado
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Body --}}
                                    <div class="p-4 d-flex flex-column flex-fill">
                                        <h3 class="fw-bold mb-2" style="color: var(--text-main, #0f172a); font-size: 1.1rem; line-height: 1.35;">
                                            {{ $program->title }}
                                        </h3>
                                        @if($program->description)
                                            <p class="text-muted mb-3 flex-fill" style="font-size: 0.88rem; line-height: 1.55;">
                                                {{ Str::limit($program->description, 100) }}
                                            </p>
                                        @endif

                                        <div class="pt-3 mt-auto d-flex align-items-center justify-content-between border-top border-light">
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="fas fa-user-circle me-1 text-primary"></i>
                                                <span class="fw-medium">{{ Str::limit($program->host, 22) }}</span>
                                            </div>
                                            <a href="{{ route('public.programs.podcasts', $program->id) }}"
                                               class="btn btn-sm rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1"
                                               style="background: rgba(30, 58, 138, 0.08); color: #1e3a8a; border: 1px solid rgba(30, 58, 138, 0.2); font-weight: 700; font-size: 0.8rem; transition: all 0.2s ease;">
                                                <i class="fas fa-headphones text-warning"></i> Podcasts
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if(!$hasPrograms)
            <div class="text-center py-5 bg-white rounded-4 shadow-sm p-5" style="border: 1px solid rgba(0,0,0,0.06);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3" style="background: rgba(30,58,138,0.08);">
                    <i class="fas fa-microphone-slash fa-3x text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark">La programación se está actualizando</h4>
                <p class="text-muted mb-4">Vuelve pronto para conocer la nueva parrilla de programas de Stereo Umachiri 98.5 FM.</p>
                <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-home me-2"></i> Volver al Inicio
                </a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.program-card').forEach(c => {
    const img = c.querySelector('.program-img');
    c.addEventListener('mouseenter', () => {
        c.style.transform = 'translateY(-6px)';
        c.style.boxShadow = '0 16px 35px -8px rgba(30, 58, 138, 0.16)';
        if(img) img.style.transform = 'scale(1.06)';
    });
    c.addEventListener('mouseleave', () => {
        c.style.transform = '';
        c.style.boxShadow = '';
        if(img) img.style.transform = '';
    });
});

document.querySelectorAll('.day-pill-link').forEach(a => {
    a.addEventListener('mouseenter', () => {
        a.style.background = 'rgba(245,158,11,0.25)';
        a.style.borderColor = 'rgba(245,158,11,0.5)';
    });
    a.addEventListener('mouseleave', () => {
        a.style.background = 'rgba(255,255,255,0.08)';
        a.style.borderColor = 'rgba(255,255,255,0.15)';
    });
    a.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(a.getAttribute('href'));
        if(target) target.scrollIntoView({ behavior:'smooth', block:'start' });
    });
});
</script>
@endpush

@endsection