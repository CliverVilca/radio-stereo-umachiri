@extends('layouts.admin')
@section('title', 'Deportes')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-trophy"></i> Deportes</h1>
    <a href="{{ route('admin.sports.create') }}" class="adm-btn adm-btn-primary"><i class="fas fa-plus"></i> Nueva Nota</a>
</div>

<div class="adm-card">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="width:56px;">Img</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Publicado</th>
                    <th style="width:110px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sports as $sport)
                    <tr>
                        <td>
                            @if($sport->image)
                                <img src="{{ asset('storage/'.$sport->image) }}" alt="" class="adm-thumb">
                            @else
                                <div class="adm-thumb-placeholder" style="background:rgba(217,119,6,0.1);color:#d97706;"><i class="fas fa-trophy"></i></div>
                            @endif
                        </td>
                        <td><div style="font-weight:600;font-size:0.875rem;">{{ Str::limit($sport->title, 60) }}</div></td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $sport->author }}</td>
                        <td style="color:var(--text-muted);font-size:0.82rem;white-space:nowrap;">
                            {{ $sport->published_at ? $sport->published_at->format('d/m/Y') : '—' }}
                        </td>
                        <td>
                            <div style="display:flex;gap:0.4rem;">
                                <a href="{{ route('admin.sports.edit', $sport->id) }}" class="adm-btn adm-btn-warning" style="padding:0.35rem 0.6rem;font-size:0.75rem;"><i class="fas fa-pen"></i></a>
                                <form action="{{ route('admin.sports.destroy', $sport->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.35rem 0.6rem;font-size:0.75rem;"
                                            onclick="return confirm('¿Eliminar?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);"><i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>No hay notas deportivas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sports->hasPages())
        <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $sports->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
