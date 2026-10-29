@extends('layouts.admin')
@section('title', 'Nueva Galería')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-images"></i> Nueva Galería</h1>
    <a href="{{ route('admin.galleries.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

<form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">

        <div class="adm-card">
            <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Información</h3>

            <div class="adm-form-group">
                <label class="adm-form-label">Título de la galería *</label>
                <input type="text" name="title" class="adm-form-control" value="{{ old('title') }}" required placeholder="Ej: Festividad de San Juan 2024">
                @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div class="adm-form-group" style="margin-bottom:0;">
                <label class="adm-form-label">Descripción</label>
                <textarea name="description" class="adm-form-control" rows="4" placeholder="Describe brevemente esta galería…">{{ old('description') }}</textarea>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Fotos</h3>
                <label for="images" style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:all 0.2s ease;"
                       onmouseover="this.style.borderColor='rgba(21,128,61,0.5)'" onmouseout="this.style.borderColor=''">
                    <i class="fas fa-images" style="font-size:1.75rem;color:var(--text-muted);display:block;margin-bottom:0.5rem;"></i>
                    <span style="font-size:0.82rem;color:var(--text-muted);font-weight:600;">Haz clic para añadir fotos</span><br>
                    <span style="font-size:0.7rem;color:#475569;">Puedes seleccionar múltiples imágenes</span>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple style="display:none;" onchange="prevMultiple(this)">
                </label>
                <div id="gallery-preview" style="display:grid;grid-template-columns:repeat(3,1fr);gap:0.35rem;margin-top:0.75rem;"></div>
                @error('images')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                @error('images.*')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div class="adm-card">
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;color:var(--text);">
                    <input type="checkbox" name="is_featured" value="1" style="accent-color:#f59e0b;width:16px;height:16px;">
                    <span>Marcar como galería destacada</span>
                </label>
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Crear Galería</button>
                <a href="{{ route('admin.galleries.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function prevMultiple(input) {
    const container = document.getElementById('gallery-preview');
    container.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const r = new FileReader();
        r.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'border-radius:6px;overflow:hidden;aspect-ratio:1;';
            div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
            container.appendChild(div);
        };
        r.readAsDataURL(file);
    });
}
</script>
@endpush
@endsection
