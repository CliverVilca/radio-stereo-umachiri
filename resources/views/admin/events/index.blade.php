@extends('layouts.admin')
@section('title', 'Eventos')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-calendar-alt"></i> Eventos</h1>
    <a href="{{ route('admin.events.create') }}" class="adm-btn adm-btn-primary"><i class="fas fa-plus"></i> Nuevo Evento</a>
</div>

<div class="adm-card">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="width:56px;">Img</th>
                    <th>Título</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th style="width:110px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>
                            @if($event->image)
                                <img src="{{ asset('storage/'.$event->image) }}" alt="" class="adm-thumb">
                            @else
                                <div class="adm-thumb-placeholder" style="background:rgba(14,165,233,0.1);color:#0ea5e9;"><i class="fas fa-calendar"></i></div>
                            @endif
                        </td>
                        <td><div style="font-weight:600;font-size:0.875rem;">{{ Str::limit($event->title, 55) }}</div>
                            @if($event->location)<div style="font-size:0.75rem;color:var(--text-muted);"><i class="fas fa-map-marker-alt me-1"></i>{{ $event->location }}</div>@endif
                        </td>
                        <td style="font-size:0.82rem;white-space:nowrap;color:var(--text-muted);">{{ $event->start_time->format('d/m/Y H:i') }}</td>
                        <td style="font-size:0.82rem;white-space:nowrap;color:var(--text-muted);">{{ $event->end_time->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($event->start_time->isToday())
                                <span class="adm-badge adm-badge-green">HOY</span>
                            @elseif($event->start_time->isFuture())
                                <span class="adm-badge adm-badge-yellow">PRÓXIMO</span>
                            @else
                                <span class="adm-badge adm-badge-gray">PASADO</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:0.4rem;">
                                <a href="{{ route('admin.events.edit', $event) }}" class="adm-btn adm-btn-warning" style="padding:0.35rem 0.6rem;font-size:0.75rem;"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.35rem 0.6rem;font-size:0.75rem;"
                                            onclick="return confirm('¿Eliminar este evento?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);"><i class="fas fa-calendar-times" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>No hay eventos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($events, 'hasPages') && $events->hasPages())
        <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $events->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
