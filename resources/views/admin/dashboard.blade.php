@extends('layouts.admin')

@section('title', 'Cabina Central')

@section('content')

<style>
    .adm-stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.15rem;
        margin-bottom: 1.75rem;
    }

    .adm-stat-card-inner {
        display: flex;
        flex-direction: column;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 1.35rem 1.25rem;
        transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    }

    .adm-stat-card-inner:hover {
        transform: translateY(-4px);
        background: var(--card-hover);
        border-color: rgba(255, 255, 255, 0.16);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.45);
    }

    .stat-glow-circle {
        position: absolute;
        right: -15px;
        top: -15px;
        width: 85px;
        height: 85px;
        border-radius: 50%;
        opacity: 0.12;
        filter: blur(10px);
        pointer-events: none;
    }

    .stat-icon-wrap {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.95rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .stat-number-val {
        font-family: var(--font-heading);
        font-size: 2.2rem;
        font-weight: 900;
        color: #ffffff;
        line-height: 1;
        letter-spacing: -0.03em;
    }

    .stat-label-text {
        font-family: var(--font-display);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-top: 0.4rem;
    }

    .dash-row-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 960px) {
        .dash-row-grid { grid-template-columns: 1fr; }
    }

    .quick-action-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.65rem 1.15rem;
        border-radius: 10px;
        font-family: var(--font-heading);
        font-size: 0.84rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.22s ease;
        letter-spacing: 0.01em;
    }

    .quick-action-pill:hover {
        transform: translateY(-2px);
        filter: brightness(1.15);
        box-shadow: 0 6px 18px rgba(0,0,0,0.3);
    }
</style>

<div class="adm-page-header">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge rounded-pill px-2.5 py-1 text-dark fw-bold" style="background: var(--gold); font-family: var(--font-display); font-size: 0.7rem; letter-spacing: 0.06em;">
                ESTACIÓN 98.5 FM
            </span>
            <span class="text-white-50 small fw-bold">SISTEMA DE GESTIÓN RADIAL</span>
        </div>
        <h1 class="adm-page-title mb-0">
            <i class="fas fa-gauge-high text-warning"></i> Cabina Central & Dashboard
        </h1>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.noticias.create') }}" class="adm-btn adm-btn-primary" id="btn-nueva-noticia">
            <i class="fas fa-plus"></i> Nueva Noticia
        </a>
        <a href="{{ route('admin.sports.create') }}" class="adm-btn adm-btn-ghost">
            <i class="fas fa-trophy text-warning"></i> Nuevo Deporte
        </a>
    </div>
</div>

{{-- ── STAT CARDS VIBRANTES ── --}}
<div class="adm-stat-grid">
    @php
    $statCards = [
        ['icon'=>'fa-newspaper', 'label'=>'Noticias', 'value'=>$stats['noticias'], 'color'=>'#ef4444', 'bg'=>'linear-gradient(135deg, #ef4444, #b91c1c)', 'route'=>'admin.noticias.index'],
        ['icon'=>'fa-trophy',    'label'=>'Deportes',  'value'=>$stats['sports'],   'color'=>'#f59e0b', 'bg'=>'linear-gradient(135deg, #f59e0b, #d97706)', 'route'=>'admin.sports.index'],
        ['icon'=>'fa-microphone-lines','label'=>'Programas', 'value'=>$stats['programs'], 'color'=>'#a855f7', 'bg'=>'linear-gradient(135deg, #a855f7, #7e22ce)', 'route'=>'admin.programs.index'],
        ['icon'=>'fa-calendar-alt',  'label'=>'Próximos Eventos','value'=>$stats['events'],'color'=>'#06b6d4', 'bg'=>'linear-gradient(135deg, #06b6d4, #0891b2)','route'=>'admin.events.index'],
        ['icon'=>'fa-images',    'label'=>'Galerías',  'value'=>$stats['galleries'],'color'=>'#10b981', 'bg'=>'linear-gradient(135deg, #10b981, #059669)', 'route'=>'admin.galleries.index'],
        ['icon'=>'fa-podcast',   'label'=>'Podcasts',  'value'=>$stats['podcasts'], 'color'=>'#ec4899', 'bg'=>'linear-gradient(135deg, #ec4899, #be185d)', 'route'=>'admin.programs.index'],
    ];
    @endphp

    @foreach($statCards as $card)
        <a href="{{ route($card['route']) }}" style="text-decoration: none;">
            <div class="adm-stat-card-inner">
                <div class="stat-glow-circle" style="background: {{ $card['color'] }};"></div>
                
                <div class="stat-icon-wrap" style="background: {{ $card['bg'] }};">
                    <i class="fas {{ $card['icon'] }}" style="color: #ffffff; font-size: 1.05rem;"></i>
                </div>
                
                <div class="stat-number-val">{{ $card['value'] }}</div>
                <div class="stat-label-text">{{ $card['label'] }}</div>
            </div>
        </a>
    @endforeach
</div>

{{-- ── ROW 2: NOTICIAS RECIENTES + EVENTOS ── --}}
<div class="dash-row-grid">

    {{-- Noticias Recientes --}}
    <div class="adm-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.35rem; padding-bottom: 0.85rem; border-bottom: 1px solid var(--card-border);">
            <h2 style="font-family: var(--font-heading); font-size: 1rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.6rem; margin: 0;">
                <i class="fas fa-newspaper" style="color: #ef4444; font-size: 0.95rem;"></i> Noticias Recientes
            </h2>
            <a href="{{ route('admin.noticias.index') }}" style="font-family: var(--font-heading); font-size: 0.78rem; font-weight: 700; color: var(--gold); text-decoration: none;">
                Ver Todas <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.85rem;">
            @forelse($recentNoticias as $n)
                <div style="display: flex; align-items: center; gap: 0.85rem; padding-bottom: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.04);">
                    @if($n->image)
                        <img src="{{ asset('storage/'.$n->image) }}" alt="" class="adm-thumb" onerror="this.src='{{ asset('assets/images/cultura-folklore.jpg') }}'">
                    @else
                        <div class="adm-thumb-placeholder"><i class="fas fa-newspaper"></i></div>
                    @endif
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-family: var(--font-heading); font-size: 0.88rem; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $n->title }}
                        </div>
                        <div style="font-size: 0.74rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                            <span class="badge rounded-pill px-2 py-0.5 text-dark fw-bold" style="background: rgba(250,204,21,0.2); color: var(--gold) !important; font-size: 0.68rem;">
                                {{ ucfirst($n->type ?? 'Noticia') }}
                            </span>
                            <span>·</span>
                            <span>{{ \Carbon\Carbon::parse($n->published_at)->diffForHumans() }}</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.noticias.edit', $n->id) }}" class="adm-btn-icon" style="font-size: 0.8rem;" title="Editar">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
            @empty
                <p style="color: var(--text-muted); font-size: 0.88rem; text-align: center; padding: 2rem 0;">No hay noticias registradas aún.</p>
            @endforelse
        </div>
    </div>

    {{-- Próximos Eventos --}}
    <div class="adm-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.35rem; padding-bottom: 0.85rem; border-bottom: 1px solid var(--card-border);">
            <h2 style="font-family: var(--font-heading); font-size: 1rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.6rem; margin: 0;">
                <i class="fas fa-calendar-alt" style="color: #06b6d4; font-size: 0.95rem;"></i> Próximos Eventos
            </h2>
            <a href="{{ route('admin.events.index') }}" style="font-family: var(--font-heading); font-size: 0.78rem; font-weight: 700; color: var(--gold); text-decoration: none;">
                Ver Todos <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.85rem;">
            @forelse($upcomingEvents as $ev)
                <div style="display: flex; align-items: center; gap: 0.85rem; padding-bottom: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.04);">
                    <div style="min-width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, rgba(250,204,21,0.2) 0%, rgba(234,179,8,0.1) 100%); border: 1px solid rgba(250,204,21,0.3); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <span style="font-family: var(--font-display); font-size: 1.15rem; font-weight: 800; color: var(--gold); line-height: 1;">{{ $ev->start_time->format('d') }}</span>
                        <span style="font-family: var(--font-display); font-size: 0.62rem; font-weight: 700; color: var(--gold); line-height: 1; text-transform: uppercase;">{{ $ev->start_time->format('M') }}</span>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-family: var(--font-heading); font-size: 0.88rem; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $ev->title }}
                        </div>
                        <div style="font-size: 0.74rem; color: var(--text-muted); margin-top: 2px;">
                            <i class="far fa-clock me-1 text-warning"></i>{{ $ev->start_time->format('H:i') }}
                            @if($ev->location) · <i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $ev->location }} @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.events.edit', $ev->id) }}" class="adm-btn-icon" style="font-size: 0.8rem;" title="Editar">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
            @empty
                <p style="color: var(--text-muted); font-size: 0.88rem; text-align: center; padding: 2rem 0;">No hay próximos eventos registrados.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ── ACCIONES RÁPIDAS DE CABINA ── --}}
<div class="adm-card">
    <div style="margin-bottom: 1.1rem;">
        <h2 style="font-family: var(--font-heading); font-size: 1.05rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.25rem;">
            <i class="fas fa-bolt text-warning"></i> Acciones Rápidas de Cabina
        </h2>
        <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">Acceso directo para publicar y actualizar contenidos al aire en Stereo Umachiri.</p>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 0.85rem;">
        @php
        $actions = [
            ['href'=>route('admin.noticias.create'),  'icon'=>'fa-newspaper',      'label'=>'Publicar Noticia',  'color'=>'#ef4444', 'border'=>'rgba(239, 68, 68, 0.35)',  'bg'=>'rgba(239, 68, 68, 0.12)'],
            ['href'=>route('admin.sports.create'),    'icon'=>'fa-trophy',         'label'=>'Subir Deportes',    'color'=>'#f59e0b', 'border'=>'rgba(245, 158, 11, 0.35)', 'bg'=>'rgba(245, 158, 11, 0.12)'],
            ['href'=>route('admin.programs.create'),  'icon'=>'fa-microphone-lines','label'=>'Nuevo Programa',   'color'=>'#a855f7', 'border'=>'rgba(168, 85, 247, 0.35)','bg'=>'rgba(168, 85, 247, 0.12)'],
            ['href'=>route('admin.events.create'),    'icon'=>'fa-calendar-plus',  'label'=>'Agendar Evento',    'color'=>'#06b6d4', 'border'=>'rgba(6, 182, 212, 0.35)',  'bg'=>'rgba(6, 182, 212, 0.12)'],
            ['href'=>route('admin.galleries.create'), 'icon'=>'fa-images',         'label'=>'Nueva Galería',     'color'=>'#10b981', 'border'=>'rgba(16, 185, 129, 0.35)','bg'=>'rgba(16, 185, 129, 0.12)'],
            ['href'=>route('admin.djs.create'),       'icon'=>'fa-headphones',     'label'=>'Registrar Locutor', 'color'=>'#ec4899', 'border'=>'rgba(236, 72, 153, 0.35)', 'bg'=>'rgba(236, 72, 153, 0.12)'],
        ];
        @endphp

        @foreach($actions as $a)
            <a href="{{ $a['href'] }}" class="quick-action-pill" style="background: {{ $a['bg'] }}; border: 1px solid {{ $a['border'] }}; color: {{ $a['color'] }};">
                <i class="fas {{ $a['icon'] }}" style="font-size: 0.9rem;"></i>
                <span>{{ $a['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

@endsection
