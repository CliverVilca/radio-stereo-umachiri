@extends('layouts.admin')
@section('title', 'Añadir DJ')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-headphones"></i> Añadir DJ / Locutor</h1>
    <a href="{{ route('admin.djs.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

<form action="{{ route('admin.djs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 280px;gap:1rem;align-items:start;">

        <div class="adm-card">
            <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Datos del locutor</h3>

            <div class="adm-form-group">
                <label class="adm-form-label">Nombre completo *</label>
                <input type="text" name="name" class="adm-form-control" value="{{ old('name') }}" required placeholder="Nombre del DJ/locutor">
                @error('name')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Biografía</label>
                <textarea name="bio" class="adm-form-control" rows="6" placeholder="Historia, experiencia y estilo del locutor…">{{ old('bio') }}</textarea>
                @error('bio')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div class="adm-form-group" style="margin-bottom:0;">
                <label class="adm-form-label">Especialidad / Género musical</label>
                <input type="text" name="specialty" class="adm-form-control" value="{{ old('specialty') }}" placeholder="Ej: Cumbia, Folklore, Noticias…">
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card" style="text-align:center;">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Foto del locutor</h3>
                <label for="photo" style="cursor:pointer;">
                    <div id="avatar-preview" style="width:120px;height:120px;border-radius:50%;background:rgba(21,128,61,0.1);border:2px dashed rgba(21,128,61,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;overflow:hidden;transition:all 0.2s ease;">
                        <i class="fas fa-camera" style="font-size:2rem;color:#22c55e;"></i>
                    </div>
                    <span style="font-size:0.78rem;color:var(--text-muted);">Haz clic para subir foto</span><br>
                    <span style="font-size:0.68rem;color:#475569;">JPG, PNG · recomendado 400×400</span>
                    <input type="file" id="photo" name="photo" accept="image/*" style="display:none;" onchange="prevAvatar(this)">
                </label>
                @error('photo')<p style="color:#f87171;font-size:0.75rem;margin-top:0.5rem;">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('admin.djs.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function prevAvatar(input) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => {
            const el = document.getElementById('avatar-preview');
            el.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
            el.style.border = '2px solid rgba(21,128,61,0.4)';
        };
        r.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
