@extends('layouts.admin')
@section('title', 'Comentarios')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-comments"></i> Comentarios</h1>
    @if($comments->total() > 0)
        <span style="font-size:0.82rem;color:var(--text-muted);">{{ $comments->total() }} total</span>
    @endif
</div>

{{-- Filter tabs --}}
<div style="display:flex;gap:0.4rem;margin-bottom:1.25rem;">
    <a href="{{ request()->url() }}" class="adm-btn {{ !request('filter') ? 'adm-btn-primary' : 'adm-btn-ghost' }}" style="font-size:0.78rem;">Todos</a>
    <a href="{{ request()->url().'?filter=pending' }}" class="adm-btn {{ request('filter')=='pending' ? 'adm-btn-warning' : 'adm-btn-ghost' }}" style="font-size:0.78rem;">Pendientes</a>
    <a href="{{ request()->url().'?filter=approved' }}" class="adm-btn {{ request('filter')=='approved' ? '' : 'adm-btn-ghost' }}" style="font-size:0.78rem;{{ request('filter')=='approved' ? 'background:rgba(21,128,61,0.15);color:#4ade80;border:1px solid rgba(21,128,61,0.25);' : '' }}">Aprobados</a>
</div>

<div style="display:flex;flex-direction:column;gap:0.75rem;">
    @forelse($comments as $comment)
        <div class="adm-card" style="padding:1rem 1.25rem;">
            <div style="display:flex;align-items:flex-start;gap:1rem;">
                {{-- Avatar --}}
                <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--gold),#d97706);display:flex;align-items:center;justify-content:center;color:#070c1d;font-weight:800;font-size:0.9rem;flex-shrink:0;">
                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                </div>
                {{-- Content --}}
                <div style="flex:1;min-width:0;">
                    <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;margin-bottom:0.4rem;">
                        <span style="font-weight:700;font-size:0.875rem;color:var(--text);">{{ $comment->name }}</span>
                        @if($comment->approved)
                            <span class="adm-badge adm-badge-green"><i class="fas fa-check me-1"></i>Aprobado</span>
                        @else
                            <span class="adm-badge adm-badge-yellow"><i class="fas fa-clock me-1"></i>Pendiente</span>
                        @endif
                        <span style="font-size:0.72rem;color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                        @if($comment->news)
                            <a href="#" style="font-size:0.72rem;color:#22c55e;text-decoration:none;">
                                <i class="fas fa-newspaper me-1"></i>{{ Str::limit($comment->news->title, 40) }}
                            </a>
                        @endif
                    </div>
                    <p style="font-size:0.875rem;color:#cbd5e1;line-height:1.5;margin:0;">{{ $comment->content }}</p>
                </div>
                {{-- Actions --}}
                <div style="display:flex;gap:0.4rem;flex-shrink:0;">
                    @if(!$comment->approved)
                        <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="adm-btn adm-btn-primary" style="padding:0.35rem 0.8rem;font-size:0.75rem;">
                                <i class="fas fa-check"></i> Aprobar
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="adm-btn adm-btn-danger" style="padding:0.35rem 0.6rem;font-size:0.75rem;"
                                onclick="return confirm('¿Eliminar este comentario?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="adm-card" style="text-align:center;padding:3rem;color:var(--text-muted);">
            <i class="fas fa-comment-slash" style="font-size:2rem;margin-bottom:1rem;display:block;"></i>
            No hay comentarios registrados.
        </div>
    @endforelse
</div>

@if($comments->hasPages())
    <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $comments->links('pagination::bootstrap-5') }}</div>
@endif
@endsection
