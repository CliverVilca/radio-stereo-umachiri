@extends('layouts.app')

@section('title', $event->title . ' - Stereo Umachiri')
@section('description', Str::limit(strip_tags($event->description), 160))

@section('content')

{{-- ── EVENT HERO ── --}}
<div style="position:relative;overflow:hidden;min-height:300px;background:#0f172a;display:flex;align-items:flex-end;">
    @if($event->image)
        <div style="position:absolute;inset:0;z-index:0;">
            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}"
                 style="width:100%;height:100%;object-fit:cover;opacity:0.25;">
        </div>
    @endif
    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(15,23,42,0.98) 0%,rgba(15,23,42,0.6) 60%,transparent 100%);z-index:1;"></div>
    <div class="container position-relative pb-4 pt-5" style="z-index:2;">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.82rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.events.index') }}" class="text-white-50 text-decoration-none">Eventos</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($event->title, 40) }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2 mb-3">
            @if($event->start_time->isToday())
                <span class="badge" style="background:#22c55e;font-weight:700;">HOY</span>
            @elseif($event->start_time->isFuture())
                <span class="badge" style="background:#f59e0b;color:#1a1a1a;font-weight:700;">PRÓXIMO</span>
            @else
                <span class="badge bg-secondary">FINALIZADO</span>
            @endif
            @if($event->is_featured)
                <span class="badge" style="background:rgba(245,158,11,0.2);color:#f59e0b;font-weight:700;"><i class="fas fa-star me-1"></i>Destacado</span>
            @endif
        </div>
        <h1 class="text-white fw-black mb-0" style="font-size:clamp(1.6rem,4vw,2.5rem);line-height:1.2;max-width:800px;">{{ $event->title }}</h1>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background:#f7f7f5;padding:2.5rem 0 3rem;">
    <div class="container">
        <div class="row g-4">

            {{-- Article --}}
            <div class="col-lg-8">
                <article class="bg-white rounded-4 p-4 p-md-5" style="border:1px solid rgba(0,0,0,0.07);">
                    @if($event->image)
                        <figure class="mb-4 rounded-4 overflow-hidden" style="max-height:420px;">
                            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}"
                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                        </figure>
                    @endif

                    <div style="font-size:1.05rem;line-height:1.8;color:#374151;">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    {{-- Share --}}
                    <div class="mt-4 pt-4" style="border-top:1px solid rgba(0,0,0,0.08);">
                        <p class="text-muted small fw-semibold mb-2">Compartir este evento:</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#1877f2;color:white;"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                            <a href="https://wa.me/?text={{ urlencode($event->title.' '.request()->fullUrl()) }}"
                               target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold"
                               style="background:#25d366;color:white;"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                            <a href="{{ route('public.events.index') }}"
                               class="btn btn-sm rounded-pill px-3 btn-outline-secondary ms-auto">
                                <i class="fas fa-arrow-left me-1"></i> Volver a Eventos
                            </a>
                        </div>
                    </div>
                </article>
            </div>

            {{-- Sidebar: Event Info --}}
            <div class="col-lg-4">
                <div class="bg-white rounded-4 overflow-hidden" style="border:1px solid rgba(0,0,0,0.07);position:sticky;top:80px;">
                    <div class="p-3" style="background:linear-gradient(135deg,#0d2a1a,#15803d);">
                        <h6 class="text-white fw-bold mb-0"><i class="fas fa-info-circle me-2"></i>Información del evento</h6>
                    </div>
                    <div class="p-4">
                        {{-- Date --}}
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="text-center rounded-3 px-2 py-2" style="background:#f59e0b;min-width:52px;">
                                <div class="text-white fw-black" style="font-size:1.6rem;line-height:1;">{{ $event->start_time->format('d') }}</div>
                                <div class="text-white fw-bold" style="font-size:0.65rem;text-transform:uppercase;">{{ $event->start_time->format('M Y') }}</div>
                            </div>
                            <div>
                                <div class="text-muted small fw-semibold">FECHA</div>
                                <div class="fw-bold" style="color:#0d2a1a;">{{ $event->start_time->translatedFormat('l, d \d\e F') }}</div>
                            </div>
                        </div>

                        {{-- Time --}}
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                                 style="width:46px;height:46px;background:rgba(21,128,61,0.1);">
                                <i class="far fa-clock" style="color:#15803d;"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-semibold">HORARIO</div>
                                <div class="fw-bold" style="color:#0d2a1a;">{{ $event->start_time->format('H:i') }} – {{ $event->end_time->format('H:i') }}</div>
                                <small class="text-muted">{{ $event->start_time->diffInHours($event->end_time) }} horas de duración</small>
                            </div>
                        </div>

                        @if($event->location)
                        {{-- Location --}}
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                                 style="width:46px;height:46px;background:rgba(245,158,11,0.1);">
                                <i class="fas fa-map-marker-alt" style="color:#d97706;"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-semibold">LUGAR</div>
                                <div class="fw-bold" style="color:#0d2a1a;">{{ $event->location }}</div>
                            </div>
                        </div>
                        @endif

                        {{-- Countdown if future --}}
                        @if($event->start_time->isFuture())
                            <div class="rounded-3 p-3 text-center" style="background:rgba(21,128,61,0.06);border:1px solid rgba(21,128,61,0.15);">
                                <div class="text-muted small fw-semibold mb-1">FALTAN</div>
                                <div class="fw-black" style="color:#15803d;font-size:1.5rem;">{{ now()->diffForHumans($event->start_time, ['parts'=>2,'syntax'=>\Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
