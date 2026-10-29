@extends('layouts.admin')

@section('title', 'Crear Noticia')

@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-newspaper"></i> Nueva Noticia</h1>
    <a href="{{ route('admin.noticias.index') }}" class="adm-btn adm-btn-ghost">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">

        {{-- LEFT: Main content --}}
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Contenido</h3>

                <div class="adm-form-group">
                    <label class="adm-form-label">Título *</label>
                    <input type="text" name="title" id="title" class="adm-form-control"
                           value="{{ old('title') }}" required placeholder="Título de la noticia…">
                    @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Contenido *</label>
                    <textarea name="content" id="content" class="adm-form-control" rows="12" required
                              placeholder="Escribe el contenido de la noticia…">{{ old('content') }}</textarea>
                    @error('content')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Autor *</label>
                    <input type="text" name="author" class="adm-form-control"
                           value="{{ old('author') }}" required placeholder="Nombre del autor">
                    @error('author')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- RIGHT: Metadata + image --}}
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Detalles</h3>

                <div class="adm-form-group">
                    <label class="adm-form-label">Fecha de Publicación *</label>
                    <input type="datetime-local" name="published_at" class="adm-form-control"
                           value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" required>
                    @error('published_at')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Tipo *</label>
                    <select name="type" class="adm-form-control" required>
                        <option value="">Seleccionar…</option>
                        <option value="local" {{ old('type')=='local' ? 'selected' : '' }}>Local</option>
                        <option value="internacional" {{ old('type')=='internacional' ? 'selected' : '' }}>Internacional</option>
                    </select>
                    @error('type')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Estado *</label>
                    <select name="status" class="adm-form-control" required>
                        <option value="">Seleccionar…</option>
                        <option value="draft"      {{ old('status')=='draft'      ? 'selected' : '' }}>Borrador</option>
                        <option value="published"  {{ old('status','published')=='published' ? 'selected' : '' }}>Publicado</option>
                    </select>
                    @error('status')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Imagen</h3>

                <label id="img-drop" for="image"
                       style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:all 0.2s ease;"
                       onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor=''">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.5rem;color:var(--text-muted);margin-bottom:0.5rem;display:block;"></i>
                    <span style="font-size:0.8rem;color:var(--text-muted);">Haz clic o arrastra una imagen</span>
                    <span style="display:block;font-size:0.7rem;color:var(--text-muted);margin-top:0.25rem;">JPG, PNG, GIF · máx. 2MB</span>
                    <input type="file" id="image" name="image" accept="image/*" style="display:none;" onchange="previewImg(this)">
                </label>
                <div id="img-preview" style="margin-top:0.75rem;display:none;border-radius:8px;overflow:hidden;">
                    <img id="preview-img" src="" alt="" style="width:100%;max-height:180px;object-fit:cover;display:block;">
                </div>
                @error('image')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('admin.noticias.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>

    </div>
</form>

@push('scripts')
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('img-preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection