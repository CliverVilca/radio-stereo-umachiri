@extends('layouts.admin')
@section('title', 'Podcasts — '.$program->title)
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-podcast"></i> Podcasts</h1>
    <div style="display:flex;gap:0.5rem;">
        <a href="{{ route('admin.programs.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Programas</a>
        <a href="{{ route('admin.programs.podcasts.create', $program) }}" class="adm-btn adm-btn-primary"><i class="fas fa-plus"></i> Nuevo Episodio</a>
    </div>
</div>

{{-- Program context --}}
<div style="display:flex;align-items:center;gap:0.75rem;padding:0.875rem 1rem;background:rgba(21,128,61,0.08);border:1px solid rgba(21,128,61,0.2);border-radius:10px;margin-bottom:1.25rem;">
    @if($program->image)
        <img src="{{ asset('storage/'.$program->image) }}" alt="" style="width:44px;height:44px;border-radius:8px;object-fit:cover;">
    @endif
    <div>
        <div style="font-size:0.72rem;color:#22c55e;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;">Programa</div>
        <div style="font-weight:700;color:var(--text);">{{ $program->title }}</div>
        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $program->host }}</div>
    </div>
    <span class="adm-badge adm-badge-green" style="margin-left:auto;">{{ $program->podcasts->count() }} episodios</span>
</div>

<div class="adm-card">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título del episodio</th>
                    <th>Audio</th>
                    <th>Fecha</th>
                    <th style="width:110px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($program->podcasts->sortByDesc('created_at') as $i => $podcast)
                    <tr>
                        <td style="color:var(--text-muted);font-size:0.8rem;font-weight:700;">{{ $i+1 }}</td>
                        <td>
                            <div style="font-weight:600;font-size:0.875rem;">{{ $podcast->title }}</div>
                            @if($podcast->description)
                                <div style="font-size:0.72rem;color:var(--text-muted);">{{ Str::limit($podcast->description, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($podcast->audio_path ?? $podcast->audio)
                                <audio controls style="height:30px;width:160px;">
                                    <source src="{{ asset('storage/'.($podcast->audio_path ?? $podcast->audio)) }}">
                                </audio>
                            @else
                                <span class="adm-badge adm-badge-gray"><i class="fas fa-times me-1"></i>Sin audio</span>
                            @endif
                        </td>
                        <td style="font-size:0.75rem;color:var(--text-muted);white-space:nowrap;">
                            {{ $podcast->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:0.4rem;">
                                <a href="{{ route('admin.programs.podcasts.edit', [$program, $podcast]) }}" class="adm-btn adm-btn-warning" style="padding:0.35rem 0.6rem;font-size:0.75rem;"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('admin.programs.podcasts.destroy', [$program, $podcast]) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.35rem 0.6rem;font-size:0.75rem;"
                                            onclick="return confirm('¿Eliminar este episodio?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">
                            <i class="fas fa-podcast" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>
                            No hay episodios aún. <a href="{{ route('admin.programs.podcasts.create', $program) }}" style="color:#22c55e;">Añadir el primero →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
