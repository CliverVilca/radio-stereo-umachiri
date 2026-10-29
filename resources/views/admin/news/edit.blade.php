@extends('layouts.admin')
@section('title', 'Editar Noticia')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-pen"></i> Editar Noticia</h1>
    <a href="{{ route('admin.noticias.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

<form action="{{ route('admin.noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Contenido</h3>

                <div class="adm-form-group">
                    <label class="adm-form-label">Título *</label>
                    <input type="text" name="title" class="adm-form-control" value="{{ old('title', $noticia->title) }}" required>
                    @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Contenido *</label>
                    <textarea name="content" class="adm-form-control" rows="12" required>{{ old('content', $noticia->content) }}</textarea>
                    @error('content')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Autor *</label>
                    <input type="text" name="author" class="adm-form-control" value="{{ old('author', $noticia->author) }}" required>
                    @error('author')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Detalles</h3>

                <div class="adm-form-group">
                    <label class="adm-form-label">Fecha de publicación *</label>
                    <input type="datetime-local" name="published_at" class="adm-form-control"
                           value="{{ old('published_at', $noticia->published_at ? $noticia->published_at->format('Y-m-d\TH:i') : '') }}" required>
                    @error('published_at')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>

                <div class="adm-form-group">
                    <label class="adm-form-label">Tipo *</label>
                    <select name="type" class="adm-form-control" required>
                        <option value="local"         {{ old('type',$noticia->type)=='local'         ? 'selected' : '' }}>Local</option>
                        <option value="internacional" {{ old('type',$noticia->type)=='internacional' ? 'selected' : '' }}>Internacional</option>
                    </select>
                </div>

                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Estado *</label>
                    <select name="status" class="adm-form-control" required>
                        <option value="draft"     {{ old('status',$noticia->status)=='draft'     ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status',$noticia->status)=='published' ? 'selected' : '' }}>Publicado</option>
                    </select>
                </div>
            </div>

            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Imagen</h3>

                @if($noticia->image)
                    <div style="border-radius:8px;overflow:hidden;margin-bottom:0.75rem;">
                        <img src="{{ asset('storage/'.$noticia->image) }}" alt="Imagen actual" style="width:100%;max-height:160px;object-fit:cover;">
                    </div>
                    <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;color:var(--text-muted);margin-bottom:0.75rem;cursor:pointer;">
                        <input type="checkbox" name="remove_image" value="1" style="accent-color:#ef4444;">
                        Eliminar imagen actual
                    </label>
                @endif

                <label for="image" style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1rem;text-align:center;cursor:pointer;">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.3rem;color:var(--text-muted);display:block;margin-bottom:0.35rem;"></i>
                    <span style="font-size:0.78rem;color:var(--text-muted);">{{ $noticia->image ? 'Cambiar imagen' : 'Subir imagen' }}</span>
                    <input type="file" id="image" name="image" accept="image/*" style="display:none;" onchange="prevImg(this,'n-img','n-div')">
                </label>
                <div id="n-div" style="display:none;margin-top:0.5rem;border-radius:8px;overflow:hidden;">
                    <img id="n-img" src="" style="width:100%;max-height:160px;object-fit:cover;">
                </div>
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('admin.noticias.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function prevImg(input, imgId, divId) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => { document.getElementById(imgId).src = e.target.result; document.getElementById(divId).style.display='block'; };
        r.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
