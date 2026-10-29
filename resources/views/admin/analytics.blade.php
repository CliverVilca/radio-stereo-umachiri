@extends('layouts.admin')
@section('title', 'Analytics')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-chart-line"></i> Analytics</h1>
    <span style="font-size:0.75rem;color:var(--text-muted);background:rgba(255,255,255,0.05);padding:0.3rem 0.75rem;border-radius:99px;border:1px solid var(--card-border);">
        <i class="fas fa-clock me-1"></i> Hoy {{ now()->format('d/m/Y') }}
    </span>
</div>

{{-- Metric Cards --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem;">
    @php
    $metrics = [
        ['icon'=>'fa-eye',       'label'=>'Vistas de Página',   'value'=>number_format($analytics['page_views']),      'color'=>'#0ea5e9'],
        ['icon'=>'fa-user',      'label'=>'Visitantes Únicos',  'value'=>number_format($analytics['unique_visitors']), 'color'=>'#22c55e'],
        ['icon'=>'fa-clock',     'label'=>'Duración Promedio',  'value'=>$analytics['avg_session_duration'],            'color'=>'#f59e0b'],
        ['icon'=>'fa-arrow-left','label'=>'Tasa de Rebote',     'value'=>$analytics['bounce_rate'],                     'color'=>'#ec4899'],
    ];
    @endphp
    @foreach($metrics as $m)
        <div style="background:var(--card-bg);border:1px solid var(--card-border);border-radius:12px;padding:1.25rem;position:relative;overflow:hidden;">
            <div style="position:absolute;right:-10px;top:-10px;width:70px;height:70px;border-radius:50%;background:{{ $m['color'] }};opacity:0.06;"></div>
            <div style="width:36px;height:36px;border-radius:9px;background:{{ $m['color'] }}1a;border:1px solid {{ $m['color'] }}33;display:flex;align-items:center;justify-content:center;margin-bottom:0.9rem;">
                <i class="fas {{ $m['icon'] }}" style="color:{{ $m['color'] }};font-size:0.9rem;"></i>
            </div>
            <div style="font-size:1.9rem;font-weight:800;color:var(--text);line-height:1;">{{ $m['value'] }}</div>
            <div style="font-size:0.75rem;font-weight:600;color:var(--text-muted);margin-top:0.3rem;">{{ $m['label'] }}</div>
        </div>
    @endforeach
</div>

{{-- Top Pages --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
    <div class="adm-card">
        <h2 style="font-size:0.92rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
            <i class="fas fa-fire" style="color:#f59e0b;font-size:0.85rem;"></i> Páginas más visitadas
        </h2>
        @php $maxViews = max($analytics['top_pages']); @endphp
        <div style="display:flex;flex-direction:column;gap:1rem;">
            @foreach($analytics['top_pages'] as $page => $views)
                <div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:0.4rem;">
                        <span style="font-size:0.82rem;color:var(--text);font-weight:600;">{{ $page }}</span>
                        <span style="font-size:0.82rem;color:var(--text-muted);">{{ number_format($views) }}</span>
                    </div>
                    <div style="height:6px;background:rgba(255,255,255,0.06);border-radius:99px;overflow:hidden;">
                        <div style="height:100%;width:{{ ($views/$maxViews)*100 }}%;background:linear-gradient(90deg,#15803d,#22c55e);border-radius:99px;transition:width 0.8s ease;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="adm-card">
        <h2 style="font-size:0.92rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;display:flex;align-items:center;gap:0.5rem;">
            <i class="fas fa-broadcast-tower" style="color:#22c55e;font-size:0.85rem;"></i> Estado de la emisora
        </h2>
        <div style="display:flex;flex-direction:column;gap:0.75rem;">
            @php
            $status = [
                ['label'=>'Transmisión FM',   'val'=>'ACTIVO',    'ok'=>true],
                ['label'=>'Stream online',    'val'=>'EN VIVO',   'ok'=>true],
                ['label'=>'Servidor web',     'val'=>'ONLINE',    'ok'=>true],
                ['label'=>'Base de datos',    'val'=>'CONECTADA', 'ok'=>true],
            ];
            @endphp
            @foreach($status as $s)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.6rem 0.75rem;background:rgba(255,255,255,0.03);border-radius:8px;border:1px solid rgba(255,255,255,0.05);">
                    <span style="font-size:0.82rem;color:var(--text-muted);">{{ $s['label'] }}</span>
                    <span class="adm-badge {{ $s['ok'] ? 'adm-badge-green' : 'adm-badge-red' }}">
                        {{ $s['ok'] ? '●' : '○' }} {{ $s['val'] }}
                    </span>
                </div>
            @endforeach
        </div>
        <div style="margin-top:1.25rem;padding:0.875rem;background:rgba(21,128,61,0.08);border:1px solid rgba(21,128,61,0.2);border-radius:10px;text-align:center;">
            <div style="font-size:0.7rem;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.25rem;">Frecuencia</div>
            <div style="font-size:2rem;font-weight:900;color:#22c55e;letter-spacing:-0.02em;">98.5 FM</div>
            <div style="font-size:0.72rem;color:#64748b;">Umachiri · Melgar · Puno · Perú</div>
        </div>
    </div>
</div>
@endsection