<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · Cabina Central — Stereo Umachiri 98.5 FM</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w: 265px;
        --sidebar-bg: #070c1d;
        --sidebar-border: rgba(255, 255, 255, 0.08);
        --body-bg: #050814;
        --card-bg: #0c142c;
        --card-border: rgba(255, 255, 255, 0.09);
        --card-hover: #101c3d;
        
        --text: #f8fafc;
        --text-muted: #94a3b8;
        --text-dim: #64748b;
        
        /* Identidad Stereo Umachiri & Prensa */
        --accent: #facc15;
        --accent-glow: rgba(250, 204, 21, 0.35);
        --accent-dark: #070c1d;
        --gold: #facc15;
        --gold-hover: #eab308;
        --red-live: #ef4444;
        --green-live: #10b981;
        --blue-info: #3b82f6;
        --purple-station: #a855f7;

        --font-heading: 'Montserrat', system-ui, sans-serif;
        --font-body: 'Plus Jakarta Sans', system-ui, sans-serif;
        --font-display: 'Oswald', sans-serif;
        --radius: 14px;
    }

    html, body { height: 100%; }

    body {
        font-family: var(--font-body);
        background: var(--body-bg);
        color: var(--text);
        line-height: 1.6;
        display: flex;
        min-height: 100vh;
        -webkit-font-smoothing: antialiased;
    }

    /* ── SIDEBAR ── */
    .adm-sidebar {
        width: var(--sidebar-w);
        min-width: var(--sidebar-w);
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 200;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        scrollbar-color: rgba(255,255,255,0.12) transparent;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .adm-brand {
        padding: 1.4rem 1.25rem 1.1rem;
        border-bottom: 1px solid var(--sidebar-border);
        background: rgba(12, 20, 44, 0.5);
    }
    .adm-brand-link {
        text-decoration: none;
        display: block;
    }
    .adm-brand-row {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }
    .adm-brand-logo-wrap {
        position: relative;
        width: 44px;
        height: 44px;
        flex-shrink: 0;
    }
    .adm-brand-img {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gold);
        box-shadow: 0 0 15px rgba(250, 204, 21, 0.3);
    }
    .adm-live-badge-mini {
        position: absolute;
        bottom: -2px;
        right: -3px;
        background: var(--red-live);
        color: white;
        font-family: var(--font-display);
        font-size: 0.58rem;
        font-weight: 700;
        padding: 1px 4px;
        border-radius: 6px;
        border: 1px solid #070c1d;
        line-height: 1.2;
    }
    .adm-brand-text { line-height: 1.2; }
    .adm-brand-name {
        font-family: var(--font-heading);
        font-size: 0.95rem;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -0.02em;
    }
    .adm-brand-fm {
        font-size: 0.72rem;
        color: var(--text-muted);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .adm-nav { padding: 1rem 0.85rem; flex: 1; }

    .adm-nav-group { margin-bottom: 1.5rem; }
    .adm-nav-label {
        font-family: var(--font-display);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-dim);
        padding: 0 0.6rem;
        margin-bottom: 0.5rem;
    }

    .adm-nav-link {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.65rem 0.85rem;
        border-radius: 10px;
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 600;
        transition: all 0.22s ease;
        margin-bottom: 3px;
        position: relative;
    }
    .adm-nav-link i {
        width: 18px;
        text-align: center;
        font-size: 0.95rem;
        flex-shrink: 0;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .adm-nav-link:hover {
        background: rgba(255,255,255,0.06);
        color: #ffffff;
        transform: translateX(2px);
    }
    .adm-nav-link:hover i {
        color: var(--gold);
        transform: scale(1.1);
    }
    .adm-nav-link.active {
        background: linear-gradient(135deg, rgba(250, 204, 21, 0.16) 0%, rgba(234, 179, 8, 0.08) 100%);
        color: var(--gold);
        border: 1px solid rgba(250, 204, 21, 0.3);
        box-shadow: 0 4px 16px rgba(250, 204, 21, 0.15);
    }
    .adm-nav-link.active i {
        color: var(--gold);
    }

    .adm-sidebar-footer {
        padding: 1rem;
        border-top: 1px solid var(--sidebar-border);
        background: rgba(7, 12, 29, 0.8);
    }
    .adm-user-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0.75rem;
        border-radius: 10px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.06);
    }
    .adm-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gold), #d97706);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #070c1d;
        font-weight: 800;
        flex-shrink: 0;
        font-family: var(--font-heading);
    }
    .adm-user-name { font-size: 0.82rem; font-weight: 700; color: #f8fafc; line-height: 1.2; }
    .adm-user-role { font-size: 0.68rem; color: var(--gold); font-weight: 600; }

    /* ── TOPBAR ── */
    .adm-topbar {
        height: 64px;
        background: rgba(12, 20, 44, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--card-border);
        display: flex;
        align-items: center;
        padding: 0 1.75rem;
        gap: 1rem;
        position: fixed;
        top: 0;
        left: var(--sidebar-w);
        right: 0;
        z-index: 100;
    }
    .adm-topbar-title {
        font-family: var(--font-heading);
        font-size: 1.05rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.02em;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .adm-topbar-actions { display: flex; align-items: center; gap: 0.75rem; }
    
    .adm-clock-badge {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.4rem 0.9rem;
        background: rgba(0,0,0,0.35);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 99px;
        font-family: var(--font-display);
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        color: #e2e8f0;
    }
    
    .adm-live-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.4);
        border-radius: 99px;
        font-family: var(--font-display);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        color: #fca5a5;
    }
    .adm-live-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--red-live);
        box-shadow: 0 0 8px var(--red-live);
        animation: livePulse 1.2s ease-in-out infinite;
    }
    @keyframes livePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(0.75); }
    }

    .adm-btn-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255,255,255,0.06);
        border: 1px solid var(--card-border);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .adm-btn-icon:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #070c1d;
        transform: translateY(-2px);
    }

    /* ── MAIN WRAPPER ── */
    .adm-main {
        margin-left: var(--sidebar-w);
        margin-top: 64px;
        flex: 1;
        padding: 2rem;
        min-height: calc(100vh - 64px);
    }

    /* ── SHARED COMPONENTS ── */
    .adm-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .adm-page-title {
        font-family: var(--font-heading);
        font-size: 1.45rem;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: -0.03em;
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .adm-page-title i { color: var(--gold); font-size: 1.2rem; }

    .adm-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 1.6rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        transition: border-color 0.2s ease;
    }
    .adm-card:hover {
        border-color: rgba(255, 255, 255, 0.14);
    }

    /* Alerts */
    .adm-alert {
        padding: 0.95rem 1.35rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
    }
    .adm-alert-success {
        background: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.3);
        color: #34d399;
    }
    .adm-alert-danger {
        background: rgba(239, 68, 68, 0.12);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #f87171;
    }
    .adm-alert-warning {
        background: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #fbbf24;
    }

    /* Tables */
    .adm-table-wrap {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--card-border);
        background: var(--card-bg);
    }
    .adm-table { width: 100%; border-collapse: collapse; }
    .adm-table th {
        background: rgba(255,255,255,0.03);
        color: var(--text-muted);
        font-family: var(--font-display);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 0.85rem 1.1rem;
        text-align: left;
        border-bottom: 1px solid var(--card-border);
    }
    .adm-table td {
        padding: 0.95rem 1.1rem;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        font-size: 0.88rem;
        color: var(--text);
        vertical-align: middle;
    }
    .adm-table tr:last-child td { border-bottom: none; }
    .adm-table tbody tr { transition: background 0.15s ease; }
    .adm-table tbody tr:hover { background: rgba(255,255,255,0.035); }

    /* Badges */
    .adm-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.25rem 0.75rem;
        border-radius: 99px;
        font-family: var(--font-display);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }
    .adm-badge-green  { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25); }
    .adm-badge-yellow { background: rgba(250, 204, 21, 0.15); color: #facc15; border: 1px solid rgba(250, 204, 21, 0.25); }
    .adm-badge-blue   { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); }
    .adm-badge-red    { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25); }
    .adm-badge-purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.25); }
    .adm-badge-gray   { background: rgba(255,255,255,0.08); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1); }

    /* Buttons */
    .adm-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.62rem 1.25rem;
        border-radius: 10px;
        font-family: var(--font-heading);
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.22s ease;
        text-decoration: none;
        letter-spacing: 0.01em;
    }
    .adm-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    .adm-btn-primary {
        background: linear-gradient(135deg, var(--gold) 0%, #eab308 100%);
        color: #070c1d;
        box-shadow: 0 4px 15px rgba(250, 204, 21, 0.25);
    }
    .adm-btn-primary:hover {
        background: linear-gradient(135deg, #fde047 0%, var(--gold) 100%);
        color: #000000;
        box-shadow: 0 6px 20px rgba(250, 204, 21, 0.4);
    }
    .adm-btn-danger  { background: rgba(239,68,68,0.18); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
    .adm-btn-warning { background: rgba(245,158,11,0.18); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
    .adm-btn-ghost   { background: rgba(255,255,255,0.06); color: var(--text-muted); border: 1px solid var(--card-border); }
    .adm-btn-ghost:hover { background: rgba(255,255,255,0.1); color: #ffffff; }

    /* Forms */
    .adm-form-group { margin-bottom: 1.35rem; }
    .adm-form-label {
        display: block;
        font-family: var(--font-heading);
        font-size: 0.8rem;
        font-weight: 700;
        color: #cbd5e1;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .adm-form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(5, 8, 20, 0.6);
        border: 1px solid var(--card-border);
        border-radius: 10px;
        color: var(--text);
        font-size: 0.9rem;
        font-family: inherit;
        transition: all 0.2s ease;
        outline: none;
    }
    .adm-form-control:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.2);
        background: rgba(5, 8, 20, 0.85);
    }
    textarea.adm-form-control { resize: vertical; min-height: 110px; }
    select.adm-form-control option { background: #070c1d; }

    /* Thumb */
    .adm-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .adm-thumb-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        background: rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1rem;
        border: 1px solid rgba(255,255,255,0.08);
    }

    /* Constrain pagination SVGs */
    nav svg, .pagination svg, [role="navigation"] svg {
        width: 1.15rem !important;
        height: 1.15rem !important;
        max-width: 18px !important;
        max-height: 18px !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }

    /* Pagination */
    .pagination {
        display: flex;
        gap: 0.35rem;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        justify-content: center;
    }
    .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--card-border);
        color: #cbd5e1;
        font-family: var(--font-heading);
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .page-item .page-link:hover {
        background: var(--gold);
        color: #070c1d;
        border-color: var(--gold);
        transform: translateY(-1px);
    }
    .page-item.active .page-link {
        background: var(--gold);
        color: #070c1d;
        border-color: var(--gold);
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.35);
    }
    .page-item.disabled .page-link {
        opacity: 0.4;
        pointer-events: none;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .adm-sidebar { transform: translateX(-100%); }
        .adm-sidebar.open { transform: translateX(0); }
        .adm-main { margin-left: 0; padding: 1.25rem; }
        .adm-topbar { left: 0; }
    }
    </style>
</head>
<body>

    {{-- ── SIDEBAR ── --}}
    <aside class="adm-sidebar" id="admSidebar">
        <div class="adm-brand">
            <a href="{{ route('admin.dashboard') }}" class="adm-brand-link">
                <div class="adm-brand-row">
                    <div class="adm-brand-logo-wrap">
                        <img src="{{ asset('assets/images/logo-modern.jpg') }}" alt="Stereo Umachiri" class="adm-brand-img" onerror="this.src='{{ asset('assets/images/logo.png') }}'">
                        <span class="adm-live-badge-mini">98.5</span>
                    </div>
                    <div class="adm-brand-text">
                        <div class="adm-brand-name">STEREO UMACHIRI</div>
                        <div class="adm-brand-fm"><i class="fas fa-tower-broadcast text-warning me-1"></i> Cabina Central FM</div>
                    </div>
                </div>
            </a>
        </div>

        <nav class="adm-nav">
            <div class="adm-nav-group">
                <div class="adm-nav-label">General</div>
                <a href="{{ route('admin.dashboard') }}" class="adm-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-gauge-high"></i> Dashboard
                </a>
                <a href="{{ route('home') }}" class="adm-nav-link" target="_blank">
                    <i class="fas fa-globe"></i> Ver Radio en Vivo
                </a>
            </div>

            <div class="adm-nav-group">
                <div class="adm-nav-label">Gestión de Contenido</div>
                <a href="{{ route('admin.noticias.index') }}" class="adm-nav-link {{ request()->routeIs('admin.noticias.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> Noticias
                </a>
                <a href="{{ route('admin.sports.index') }}" class="adm-nav-link {{ request()->routeIs('admin.sports.*') ? 'active' : '' }}">
                    <i class="fas fa-trophy"></i> Deportes
                </a>
                <a href="{{ route('admin.programs.index') }}" class="adm-nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}">
                    <i class="fas fa-microphone-lines"></i> Programas
                </a>
                <a href="{{ route('admin.events.index') }}" class="adm-nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Eventos
                </a>
                <a href="{{ route('admin.galleries.index') }}" class="adm-nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> Galerías
                </a>
                <a href="{{ route('admin.djs.index') }}" class="adm-nav-link {{ request()->routeIs('admin.djs.*') ? 'active' : '' }}">
                    <i class="fas fa-headphones"></i> Locutores & DJs
                </a>
            </div>

            <div class="adm-nav-group">
                <div class="adm-nav-label">Audiencia & Análisis</div>
                <a href="{{ route('admin.comments.index') }}" class="adm-nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i> Comentarios
                </a>
                <a href="{{ route('admin.messages') }}" class="adm-nav-link {{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Mensajes Cabina
                </a>
                <a href="{{ route('admin.analytics') }}" class="adm-nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Estadísticas
                </a>
            </div>
        </nav>

        <div class="adm-sidebar-footer">
            <div class="adm-user-row">
                <div class="adm-avatar">{{ auth()->check() ? strtoupper(substr(auth()->user()->name,0,1)) : 'A' }}</div>
                <div style="overflow: hidden;">
                    <div class="adm-user-name text-truncate">{{ auth()->check() ? auth()->user()->name : 'Administrador' }}</div>
                    <div class="adm-user-role">Super Administrador</div>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   class="adm-btn-icon ms-auto" title="Cerrar sesión" style="margin-left:auto;text-decoration:none;">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>
    </aside>

    {{-- ── TOPBAR ── --}}
    <header class="adm-topbar">
        <button class="adm-btn-icon d-md-none" onclick="document.getElementById('admSidebar').classList.toggle('open')">
            <i class="fas fa-bars"></i>
        </button>
        <div class="adm-topbar-title">
            <span>@yield('title', 'Dashboard')</span>
        </div>
        <div class="adm-topbar-actions">
            {{-- Reloj Digital Altiplano --}}
            <div class="adm-clock-badge d-none d-sm-flex" id="liveClock">
                <i class="far fa-clock text-warning"></i>
                <span id="clockDisplay">--:--:--</span>
            </div>

            {{-- Live Badge --}}
            <div class="adm-live-badge">
                <span class="adm-live-dot"></span>
                <span>98.5 FM AL AIRE</span>
            </div>

            <a href="{{ route('home') }}" class="adm-btn-icon" target="_blank" title="Abrir Radio en Vivo">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
    </header>

    {{-- ── CONTENT ── --}}
    <main class="adm-main">
        @if(session('success'))
            <div class="adm-alert adm-alert-success">
                <i class="fas fa-check-circle fa-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="adm-alert adm-alert-danger">
                <i class="fas fa-exclamation-circle fa-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Reloj digital en vivo para el Altiplano
        function updateClock() {
            const clockEl = document.getElementById('clockDisplay');
            if (!clockEl) return;
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            clockEl.textContent = `${hours}:${minutes}:${seconds} (PET)`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

    @stack('scripts')
</body>
</html>
