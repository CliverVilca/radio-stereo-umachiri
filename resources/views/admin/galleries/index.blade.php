@extends('layouts.admin')
@section('title', 'Galerías')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-images"></i> Galerías</h1>
    <a href="{{ route('admin.galleries.create') }}" class="adm-btn adm-btn-primary"><i class="fas fa-plus"></i> Nueva Galería</a>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem;">
    @forelse($galleries as $gallery)
        <div style="background:var(--card-bg);border:1px solid var(--card-border);border-radius:12px;overflow:hidden;transition:all 0.2s ease;"
             onmouseover="this.style.borderColor='rgba(21,128,61,0.3)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.borderColor='var(--card-border)';this.style.transform=''">
            {{-- Preview image --}}
            <div style="height:150px;background:#1a2433;position:relative;overflow:hidden;">
                @if($gallery->images && count($gallery->images) > 0)
                    <img src="{{ asset('storage/'.$gallery->images[0]) }}" alt="{{ $gallery->title }}"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform=''">
                @else
                    <div style="height:100%;display:flex;align-items:center;justify-content:center;background:rgba(245,158,11,0.06);">
                        <i class="fas fa-images" style="font-size:2rem;color:rgba(245,158,11,0.4);"></i>
                    </div>
                @endif
                @if($gallery->is_featured)
                    <span class="adm-badge adm-badge-yellow" style="position:absolute;top:8px;right:8px;"><i class="fas fa-star me-1"></i>Destacada</span>
                @endif
                <div style="position:absolute;bottom:8px;left:8px;">
                    <span class="adm-badge adm-badge-gray"><i class="fas fa-images me-1"></i>{{ $gallery->images ? count($gallery->images) : 0 }} fotos</span>
                </div>
            </div>
            <div style="padding:1rem;">
                <div style="font-weight:700;font-size:0.875rem;color:var(--text);margin-bottom:0.25rem;">{{ Str::limit($gallery->title, 40) }}</div>
                @if($gallery->description)
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.75rem;">{{ Str::limit($gallery->description, 60) }}</div>
                @endif
                <div style="display:flex;gap:0.4rem;margin-top:auto;">
                    <a href="{{ route('admin.galleries.edit', $gallery) }}" class="adm-btn adm-btn-warning" style="flex:1;justify-content:center;padding:0.4rem;font-size:0.78rem;">
                        <i class="fas fa-pen"></i> Editar
                    </a>
                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.4rem 0.6rem;font-size:0.78rem;"
                                onclick="return confirm('¿Eliminar esta galería?')"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-muted);">
            <i class="fas fa-images" style="font-size:2rem;margin-bottom:1rem;display:block;"></i>
            No hay galerías registradas aún.
        </div>
    @endforelse
</div>

@if(method_exists($galleries, 'hasPages') && $galleries->hasPages())
    <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $galleries->links('pagination::bootstrap-5') }}</div>
@endif
@endsection
