@extends('layouts.admin')
@section('title', 'Nueva Nota Deportiva')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-trophy"></i> Nueva Nota Deportiva</h1>
    <a href="{{ route('admin.sports.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

<form action="{{ route('admin.sports.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">
        <div class="adm-card">
            <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Contenido</h3>
            <div class="adm-form-group">
                <label class="adm-form-label">Título *</label>
                <input type="text" name="title" class="adm-form-control" value="{{ old('title') }}" required placeholder="Título de la nota deportiva">
                @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Contenido *</label>
                <textarea name="content" class="adm-form-control" rows="10" required placeholder="Desarrolla la nota deportiva…">{{ old('content') }}</textarea>
                @error('content')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>
            <div class="adm-form-group" style="margin-bottom:0;">
                <label class="adm-form-label">Autor *</label>
                <input type="text" name="author" class="adm-form-control" value="{{ old('author') }}" required placeholder="Nombre del redactor">
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Detalles</h3>
                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Fecha de publicación *</label>
                    <input type="date" name="published_at" class="adm-form-control" value="{{ old('published_at', now()->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Imagen</h3>
                <label for="image" style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1.25rem;text-align:center;cursor:pointer;">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.3rem;color:var(--text-muted);display:block;margin-bottom:0.35rem;"></i>
                    <span style="font-size:0.78rem;color:var(--text-muted);">Subir imagen</span>
                    <input type="file" id="image" name="image" accept="image/*" style="display:none;" onchange="prevImg(this,'si','sd')">
                </label>
                <div id="sd" style="display:none;margin-top:0.5rem;border-radius:8px;overflow:hidden;"><img id="si" src="" style="width:100%;max-height:160px;object-fit:cover;"></div>
            </div>
            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('admin.sports.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>
@push('scripts')
<script>function prevImg(i,id,di){if(i.files&&i.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById(id).src=e.target.result;document.getElementById(di).style.display='block';};r.readAsDataURL(i.files[0]);}}</script>
@endpush
@endsection
