@extends('layouts.admin')
@section('title', 'Programas')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-microphone"></i> Programas</h1>
    <a href="{{ route('admin.programs.create') }}" class="adm-btn adm-btn-primary"><i class="fas fa-plus"></i> Nuevo Programa</a>
</div>

@php
$dayColors = ['Lunes'=>'#15803d','Martes'=>'#0ea5e9','Miércoles'=>'#7c3aed','Jueves'=>'#d97706','Viernes'=>'#ec4899','Sábado'=>'#059669','Domingo'=>'#dc2626'];
@endphp

@foreach($days as $day)
    @if(isset($programs[$day]) && $programs[$day]->count() > 0)
    <div class="adm-card" style="margin-bottom:1rem;">
        <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
            <div style="width:10px;height:10px;border-radius:50%;background:{{ $dayColors[$day] ?? '#15803d' }};flex-shrink:0;"></div>
            <h2 style="font-size:0.9rem;font-weight:700;color:var(--text);margin:0;">{{ $day }}</h2>
            <span class="adm-badge" style="background:{{ $dayColors[$day] ?? '#15803d' }}1a;color:{{ $dayColors[$day] ?? '#15803d' }};">
                {{ $programs[$day]->count() }} programa{{ $programs[$day]->count() != 1 ? 's' : '' }}
            </span>
        </div>
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th style="width:56px;">Img</th>
                        <th>Título</th>
                        <th>Conductor</th>
                        <th>Horario</th>
                        <th style="width:160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs[$day]->sortBy('start_time') as $program)
                    <tr>
                        <td>
                            @if($program->image)
                                <img src="{{ asset('storage/'.$program->image) }}" alt="" class="adm-thumb">
                            @else
                                <div class="adm-thumb-placeholder" style="background:rgba(124,58,237,0.1);color:#7c3aed;"><i class="fas fa-microphone"></i></div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:0.875rem;">{{ $program->title }}</div>
                            @if($program->description)
                                <div style="font-size:0.72rem;color:var(--text-muted);">{{ Str::limit($program->description, 50) }}</div>
                            @endif
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $program->host }}</td>
                        <td>
                            <span class="adm-badge adm-badge-blue" style="font-family:monospace;font-size:0.75rem;">
                                {{ \Carbon\Carbon::parse($program->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($program->end_time)->format('H:i') }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:0.4rem;">
                                <a href="{{ route('admin.programs.edit', $program->id) }}" class="adm-btn adm-btn-warning" style="padding:0.35rem 0.6rem;font-size:0.75rem;"><i class="fas fa-pen"></i></a>
                                <a href="{{ route('admin.programs.podcasts.index', $program->id) }}" class="adm-btn adm-btn-ghost" style="padding:0.35rem 0.6rem;font-size:0.75rem;" title="Podcasts"><i class="fas fa-podcast"></i></a>
                                <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.35rem 0.6rem;font-size:0.75rem;"
                                            onclick="return confirm('¿Eliminar este programa?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endforeach

@if(!collect($days)->contains(fn($d) => isset($programs[$d]) && $programs[$d]->count() > 0))
    <div class="adm-card" style="text-align:center;padding:3rem;color:var(--text-muted);">
        <i class="fas fa-microphone-slash" style="font-size:2rem;margin-bottom:1rem;display:block;"></i>
        No hay programas registrados aún.
    </div>
@endif
@endsection
