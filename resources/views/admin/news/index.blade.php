@extends('layouts.admin')

@section('title', 'Noticias')

@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-newspaper"></i> Noticias</h1>
    <a href="{{ route('admin.noticias.create') }}" class="adm-btn adm-btn-primary" id="btn-nueva-noticia">
        <i class="fas fa-plus"></i> Nueva Noticia
    </a>
</div>

<div class="adm-card">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="width:56px;">Img</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th style="width:100px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($noticias as $item)
                    <tr>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" alt="" class="adm-thumb">
                            @else
                                <div class="adm-thumb-placeholder"><i class="fas fa-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:0.875rem;">{{ Str::limit($item->title, 65) }}</div>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;">{{ $item->author }}</td>
                        <td>
                            <span class="adm-badge {{ $item->type == 'local' ? 'adm-badge-green' : 'adm-badge-blue' }}">
                                {{ $item->type == 'local' ? 'Local' : 'Internacional' }}
                            </span>
                        </td>
                        <td style="color:var(--text-muted);font-size:0.82rem;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($item->published_at)->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:0.4rem;">
                                <a href="{{ route('admin.noticias.edit', $item->id) }}" class="adm-btn adm-btn-warning" style="padding:0.35rem 0.6rem;font-size:0.75rem;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.noticias.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.35rem 0.6rem;font-size:0.75rem;"
                                            onclick="return confirm('¿Eliminar esta noticia?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">
                            <i class="fas fa-inbox" style="font-size:1.5rem;margin-bottom:0.5rem;display:block;"></i>
                            No hay noticias registradas aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($noticias->hasPages())
        <div style="margin-top:1.5rem;display:flex;justify-content:center;">
            {{ $noticias->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
