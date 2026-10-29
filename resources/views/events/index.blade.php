@extends('layouts.app')

@section('title', 'Eventos - Stereo Umachiri 98.5 FM')
@section('description', 'Próximos eventos culturales, festivos y comunitarios en Umachiri, Melgar y Puno.')

@section('content')

{{-- ── PAGE HERO ── --}}
<div class="position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #172554 100%);">
    <div style="position: absolute; right: -5%; top: -50%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(245,158,11,0.18), transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; left: -10%; bottom: -40%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%); pointer-events: none;"></div>

    <div class="container position-relative py-2">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-primary"><i class="fas fa-home me-1"></i>Inicio</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Eventos</li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-4 shadow-sm" style="width: 58px; height: 58px; background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="fas fa-calendar-star text-white fa-xl"></i>
            </div>
            <div>
                <span class="badge rounded-pill px-3 py-1 mb-1" style="background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); font-weight: 700; font-size: 0.72rem;">
                    AGENDA CULTURAL & COMUNITARIA
                </span>
                <h1 class="text-white fw-black mb-1" style="font-size: clamp(1.8rem, 3.5vw, 2.5rem); letter-spacing: -0.03em;">Próximos Eventos</h1>
                <p class="text-white-50 mb-0 small">Fiestas patronales, eventos cívicos, ferias y actividades en Melgar y Puno</p>
            </div>
        </div>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<section style="background: var(--bg-body, #f8fafc); padding: 3rem 0 4rem;">
    <div class="container">
        @if($events->count() > 0)
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('public.events.show', $event->id) }}" class="text-decoration-none d-block h-100">
                            <article class="event-card bg-white rounded-4 overflow-hidden h-100 d-flex flex-column shadow-sm" style="border: 1px solid rgba(0,0,0,0.06); border-top: 4px solid {{ $event->start_time->isFuture() ? '#f59e0b' : ($event->start_time->isToday() ? '#2563eb' : '#94a3b8') }}; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
                                {{-- Image --}}
                                <div style="height: 180px; overflow: hidden; background: #0f172a; position: relative;">
                                    @if($event->image)
                                        <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}"
                                             class="event-card-img"
                                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                    @else
                                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1e3a8a, #3b82f6); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-calendar-alt fa-3x text-white opacity-50"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Body --}}
                                <div class="p-4 d-flex flex-column flex-fill">
                                    <div class="d-flex align-items-start gap-3 mb-3">
                                        {{-- Date badge --}}
                                        <div class="text-center rounded-3 px-2 py-1.5 flex-shrink-0 shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #d97706); min-width: 52px;">
                                            <div class="fw-black text-white" style="font-size: 1.4rem; line-height: 1;">{{ $event->start_time->format('d') }}</div>
                                            <div class="text-white" style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">{{ $event->start_time->format('M') }}</div>
                                        </div>
                                        <div class="flex-fill">
                                            @if($event->start_time->isToday())
                                                <span class="badge rounded-pill mb-1" style="background: #2563eb; color: #fff; font-size: 0.7rem; font-weight: 700;">¡ES HOY!</span>
                                            @elseif($event->start_time->isFuture())
                                                <span class="badge rounded-pill mb-1" style="background: rgba(245,158,11,0.15); color: #b45309; font-size: 0.7rem; font-weight: 700;">PRÓXIMO</span>
                                            @else
                                                <span class="badge rounded-pill mb-1 bg-secondary bg-opacity-25 text-secondary" style="font-size: 0.7rem;">PASADO</span>
                                            @endif
                                            <h3 class="fw-bold text-dark mb-0" style="font-size: 1.05rem; line-height: 1.35;">{{ Str::limit($event->title, 55) }}</h3>
                                        </div>
                                    </div>

                                    @if($event->description)
                                        <p class="text-muted mb-3 flex-fill" style="font-size: 0.88rem; line-height: 1.55;">{{ Str::limit($event->description, 95) }}</p>
                                    @endif

                                    <div class="pt-3 mt-auto border-top border-light d-flex flex-column gap-1.5">
                                        <small class="text-muted"><i class="far fa-clock me-1 text-primary"></i> {{ $event->start_time->format('H:i') }} - {{ $event->end_time->format('H:i') }}</small>
                                        @if($event->location)
                                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ Str::limit($event->location, 35) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm p-5" style="border: 1px solid rgba(0,0,0,0.06);">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3" style="background: rgba(30,58,138,0.08);">
                    <i class="fas fa-calendar-times fa-3x text-primary"></i>
                </div>
                <h4 class="fw-bold text-dark">No hay eventos programados en este momento</h4>
                <p class="text-muted mb-4">Mantente al tanto de nuestras transmisiones para conocer las próximas actividades de la comunidad.</p>
                <a href="{{ url('/') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-home me-2"></i> Volver al Inicio
                </a>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.event-card').forEach(c => {
    const img = c.querySelector('.event-card-img');
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
</script>
@endpush

@endsection