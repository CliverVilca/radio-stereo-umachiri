@extends('layouts.admin')
@section('title', 'Editar Evento')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-calendar-alt"></i> Editar Evento</h1>
    <a href="{{ route('admin.events.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

<form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">

        <div class="adm-card">
            <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Información</h3>
            <div class="adm-form-group">
                <label class="adm-form-label">Título del evento *</label>
                <input type="text" name="title" class="adm-form-control" value="{{ old('title', $event->title) }}" required>
                @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Descripción *</label>
                <textarea name="description" class="adm-form-control" rows="6" required>{{ old('description', $event->description) }}</textarea>
            </div>
            <div class="adm-form-group" style="margin-bottom:0;">
                <label class="adm-form-label">Ubicación</label>
                <input type="text" name="location" class="adm-form-control" value="{{ old('location', $event->location) }}">
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Fecha y Hora</h3>
                <div class="adm-form-group">
                    <label class="adm-form-label">Inicio *</label>
                    <input type="datetime-local" name="start_time" class="adm-form-control"
                           value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Fin *</label>
                    <input type="datetime-local" name="end_time" class="adm-form-control"
                           value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i')) }}" required>
                </div>
            </div>

            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Imagen</h3>
                @if($event->image)
                    <div style="border-radius:8px;overflow:hidden;margin-bottom:0.75rem;">
                        <img src="{{ asset('storage/'.$event->image) }}" style="width:100%;max-height:150px;object-fit:cover;">
                    </div>
                @endif
                <label for="image" style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1rem;text-align:center;cursor:pointer;">
                    <i class="fas fa-cloud-upload-alt" style="color:var(--text-muted);display:block;margin-bottom:0.25rem;"></i>
                    <span style="font-size:0.78rem;color:var(--text-muted);">{{ $event->image ? 'Cambiar imagen' : 'Subir imagen' }}</span>
                    <input type="file" id="image" name="image" accept="image/*" style="display:none;" onchange="prevImg(this,'ei','ed')">
                </label>
                <div id="ed" style="display:none;margin-top:0.5rem;border-radius:8px;overflow:hidden;">
                    <img id="ei" src="" style="width:100%;max-height:150px;object-fit:cover;">
                </div>
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('admin.events.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@push('scripts')
<script>function prevImg(i,id,di){if(i.files&&i.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById(id).src=e.target.result;document.getElementById(di).style.display='block';};r.readAsDataURL(i.files[0]);}}</script>
@endpush
@endsection
