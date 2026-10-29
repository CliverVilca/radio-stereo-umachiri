@extends('layouts.admin')
@section('title', 'Nuevo Programa')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-microphone"></i> Nuevo Programa</h1>
    <a href="{{ route('admin.programs.index') }}" class="adm-btn adm-btn-ghost"><i class="fas fa-arrow-left"></i> Volver</a>
</div>

<form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1rem;align-items:start;">

        <div class="adm-card">
            <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Información del programa</h3>

            <div class="adm-form-group">
                <label class="adm-form-label">Nombre del programa *</label>
                <input type="text" name="title" class="adm-form-control" value="{{ old('title') }}" required placeholder="Ej: Despertar Umachiri">
                @error('title')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Descripción</label>
                <textarea name="description" class="adm-form-control" rows="4" placeholder="Breve descripción del programa…">{{ old('description') }}</textarea>
            </div>

            <div class="adm-form-group">
                <label class="adm-form-label">Conductor / Host *</label>
                <input type="text" name="host" class="adm-form-control" value="{{ old('host') }}" required placeholder="Nombre del conductor">
                @error('host')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
            </div>

            <div class="adm-form-group" style="margin-bottom:0;">
                <label class="adm-form-label">Días de emisión</label>
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:0.25rem;">
                    @foreach($days as $day)
                        <label style="display:flex;align-items:center;gap:0.4rem;padding:0.4rem 0.75rem;background:rgba(255,255,255,0.04);border:1px solid var(--card-border);border-radius:8px;cursor:pointer;font-size:0.82rem;transition:all 0.15s ease;"
                               onmouseover="this.style.borderColor='rgba(21,128,61,0.4)'" onmouseout="this.style.borderColor='var(--card-border)'">
                            <input type="checkbox" name="days_of_week[]" value="{{ $day }}"
                                   {{ is_array(old('days_of_week')) && in_array($day, old('days_of_week')) ? 'checked' : '' }}
                                   style="accent-color:#15803d;">
                            {{ $day }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Horario</h3>
                <div class="adm-form-group">
                    <label class="adm-form-label">Hora de inicio *</label>
                    <input type="time" name="start_time" class="adm-form-control" value="{{ old('start_time') }}" required>
                    @error('start_time')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>
                <div class="adm-form-group" style="margin-bottom:0;">
                    <label class="adm-form-label">Hora de fin *</label>
                    <input type="time" name="end_time" class="adm-form-control" value="{{ old('end_time') }}" required>
                    @error('end_time')<p style="color:#f87171;font-size:0.75rem;margin-top:0.35rem;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="adm-card">
                <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">Imagen</h3>
                <label for="prog-img" style="display:block;border:2px dashed var(--card-border);border-radius:10px;padding:1.25rem;text-align:center;cursor:pointer;">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.3rem;color:var(--text-muted);display:block;margin-bottom:0.35rem;"></i>
                    <span style="font-size:0.78rem;color:var(--text-muted);">Subir portada del programa</span>
                    <input type="file" id="prog-img" name="image" accept="image/*" style="display:none;" onchange="prevImg(this,'pi','pd')">
                </label>
                <div id="pd" style="display:none;margin-top:0.5rem;border-radius:8px;overflow:hidden;">
                    <img id="pi" src="" style="width:100%;max-height:160px;object-fit:cover;">
                </div>
            </div>

            <div style="display:flex;gap:0.5rem;">
                <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;justify-content:center;"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('admin.programs.index') }}" class="adm-btn adm-btn-ghost">Cancelar</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>function prevImg(i,id,di){if(i.files&&i.files[0]){const r=new FileReader();r.onload=e=>{document.getElementById(id).src=e.target.result;document.getElementById(di).style.display='block';};r.readAsDataURL(i.files[0]);}}</script>
@endpush
@endsection
