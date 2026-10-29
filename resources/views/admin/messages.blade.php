@extends('layouts.admin')
@section('title', 'Mensajes de Contacto')
@section('content')

<div class="adm-page-header">
    <h1 class="adm-page-title"><i class="fas fa-envelope"></i> Mensajes de Contacto</h1>
</div>

<div class="adm-card">
    <div class="adm-table-wrap">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Remitente</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th style="width:120px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:0.875rem;color:var(--text);">{{ $msg->name }}</div>
                            <div style="font-size:0.72rem;color:#22c55e;">{{ $msg->email }}</div>
                        </td>
                        <td style="font-size:0.82rem;">{{ $msg->subject ?? '—' }}</td>
                        <td style="font-size:0.82rem;color:var(--text-muted);max-width:240px;">{{ Str::limit($msg->message, 80) }}</td>
                        <td>
                            @if(($msg->status ?? 'new') === 'new')
                                <span class="adm-badge adm-badge-green">Nuevo</span>
                            @elseif($msg->status === 'read')
                                <span class="adm-badge adm-badge-yellow">Leído</span>
                            @else
                                <span class="adm-badge adm-badge-blue">Respondido</span>
                            @endif
                        </td>
                        <td style="font-size:0.75rem;color:var(--text-muted);white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($msg->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:0.4rem;">
                                <button onclick="openMsgModal({{ json_encode($msg) }})"
                                        class="adm-btn adm-btn-ghost" style="padding:0.35rem 0.6rem;font-size:0.75rem;" title="Ver mensaje">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="mailto:{{ $msg->email }}?subject=Re: {{ $msg->subject ?? 'Mensaje' }}"
                                   class="adm-btn adm-btn-primary" style="padding:0.35rem 0.6rem;font-size:0.75rem;" title="Responder">
                                    <i class="fas fa-reply"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">
                            <i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>
                            La bandeja de entrada está vacía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
        <div style="margin-top:1.5rem;display:flex;justify-content:center;">{{ $messages->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

{{-- Modal --}}
<div id="msgModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#141d26;border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:1.75rem;max-width:540px;width:90%;position:relative;">
        <button onclick="document.getElementById('msgModal').style.display='none'"
                style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:8px;width:32px;height:32px;color:#94a3b8;cursor:pointer;font-size:1rem;">×</button>
        <h3 style="font-size:1rem;font-weight:700;color:var(--text);margin-bottom:1.25rem;"><i class="fas fa-envelope-open" style="color:#22c55e;margin-right:0.5rem;"></i>Mensaje completo</h3>
        <div id="msgModalContent"></div>
        <a id="msgModalReply" href="#" class="adm-btn adm-btn-primary" style="margin-top:1.25rem;display:inline-flex;">
            <i class="fas fa-reply"></i> Responder por email
        </a>
    </div>
</div>

@push('scripts')
<script>
function openMsgModal(msg) {
    const modal = document.getElementById('msgModal');
    const content = document.getElementById('msgModalContent');
    content.innerHTML = `
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
            <div><div style="font-size:0.7rem;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.25rem;">Nombre</div>
                 <div style="font-size:0.875rem;color:#e2e8f0;font-weight:600;">${msg.name}</div></div>
            <div><div style="font-size:0.7rem;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.25rem;">Email</div>
                 <div style="font-size:0.875rem;color:#22c55e;">${msg.email}</div></div>
        </div>
        ${msg.subject ? `<div style="margin-bottom:0.75rem;"><div style="font-size:0.7rem;color:#64748b;font-weight:700;text-transform:uppercase;margin-bottom:0.25rem;">Asunto</div>
            <div style="font-size:0.875rem;color:#e2e8f0;font-weight:600;">${msg.subject}</div></div>` : ''}
        <div><div style="font-size:0.7rem;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem;">Mensaje</div>
            <div style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);border-radius:8px;padding:1rem;font-size:0.875rem;color:#cbd5e1;line-height:1.6;">${msg.message}</div></div>
    `;
    document.getElementById('msgModalReply').href = `mailto:${msg.email}?subject=Re: ${msg.subject || 'Mensaje'}`;
    modal.style.display = 'flex';
}
document.getElementById('msgModal').addEventListener('click', function(e) {
    if(e.target === this) this.style.display = 'none';
});
</script>
@endpush
@endsection