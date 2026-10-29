@extends('layouts.admin')
@section('title', 'DJs / Locutores')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-headphones"></i> DJs / Locutores</h1>
    <a href="{{ route('admin.djs.create') }}" class="adm-btn adm-btn-primary"><i class="fas fa-plus"></i> Añadir DJ</a>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;">
    @forelse($djs as $dj)
        <div style="background:var(--card-bg);border:1px solid var(--card-border);border-radius:12px;overflow:hidden;text-align:center;transition:all 0.2s ease;"
             onmouseover="this.style.borderColor='rgba(21,128,61,0.3)';this.style.transform='translateY(-2px)'"
             onmouseout="this.style.borderColor='var(--card-border)';this.style.transform=''">
            <div style="height:180px;overflow:hidden;background:linear-gradient(135deg,#0d1117,#1a2433);position:relative;">
                @if($dj->photo)
                    <img src="{{ asset('storage/'.$dj->photo) }}" alt="{{ $dj->name }}"
                         style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform=''">
                @else
                    <div style="height:100%;display:flex;align-items:center;justify-content:center;">
                        <div style="width:80px;height:80px;border-radius:50%;background:rgba(21,128,61,0.1);border:2px solid rgba(21,128,61,0.2);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-user" style="font-size:2rem;color:#22c55e;"></i>
                        </div>
                    </div>
                @endif
            </div>
            <div style="padding:1rem;">
                <div style="font-weight:700;font-size:0.9rem;color:var(--text);margin-bottom:0.25rem;">{{ $dj->name }}</div>
                @if($dj->bio)
                    <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:0.75rem;">{{ Str::limit($dj->bio, 55) }}</div>
                @endif
                <div style="display:flex;gap:0.4rem;justify-content:center;">
                    <a href="{{ route('admin.djs.edit', $dj) }}" class="adm-btn adm-btn-warning" style="flex:1;justify-content:center;padding:0.4rem;font-size:0.78rem;">
                        <i class="fas fa-pen"></i> Editar
                    </a>
                    <form action="{{ route('admin.djs.destroy', $dj) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.4rem 0.6rem;font-size:0.78rem;"
                                onclick="return confirm('¿Eliminar este DJ?')"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--text-muted);">
            <i class="fas fa-headphones" style="font-size:2rem;margin-bottom:1rem;display:block;"></i>
            No hay DJs registrados aún.
        </div>
    @endforelse
</div>
@endsection
