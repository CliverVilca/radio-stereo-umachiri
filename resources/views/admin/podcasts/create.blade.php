@extends('layouts.admin')
@section('title', 'Nuevo Podcast — '.$program->title)
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-podcast"></i> Nuevo episodio</h1>
    <a href="{{ route('admin.programs.podcasts.index', $program) }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

{{-- Context card --}}
<div style="display:flex;align-items:center;gap:0.75rem;padding:0.875rem 1rem;background:rgba(21,128,61,0.08);border:1px solid rgba(21,128,61,0.2);border-radius:10px;margin-bottom:1.25rem;">
    @if($program->image)
        <img src="{{ asset('storage/'.$program->image) }}" alt="" style="width:44px;height:44px;border-radius:8px;object-fit:cover;">
    @endif
    <div>
        <div style="font-size:0.72rem;color:#22c55e;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;">Programa</div>
        <div style="font-weight:700;color:var(--text);">{{ $program->title }}</div>
        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $program->host }}</div>
    </div>
</div>

<form action="{{ route('admin.programs.podcasts.store', $program) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">

        <div class="adm-card">
            <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Información del episodio</h3>
            <div class="adm-form-group">
                <label class="adm-form-label">Título del episodio *</label>
                <input type="text" name="title" class="adm-form-control" value="{{ old('title') }}" required placeholder="Ej: Episodio 12 — Noticias de la semana">
                @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>
            <div class="adm-form-group" style="margin-bottom:0;">
                <label class="adm-form-label">Descripción</label>
                <textarea name="description" class="adm-form-control" rows="5" placeholder="Resumen de lo que trata este episodio…">{{ old('description') }}</textarea>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Archivo de audio *</h3>
                <label for="audio" style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:all 0.2s ease;"
                       onmouseover="this.style.borderColor='rgba(21,128,61,0.5)'" onmouseout="this.style.borderColor=''">
                    <i class="fas fa-headphones" style="font-size:2rem;color:var(--text-muted);display:block;margin-bottom:0.5rem;"></i>
                    <span style="font-size:0.82rem;color:var(--text-muted);" id="audio-label">Seleccionar archivo MP3 / WAV</span>
                    <input type="file" id="audio" name="audio" accept="audio/*" style="display:none;" required
                           onchange="document.getElementById('audio-label').textContent=this.files[0].name">
                </label>
                @error('audio')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Guardar episodio</button>
                <a href="{{ route('admin.programs.podcasts.index', $program) }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@endsection
