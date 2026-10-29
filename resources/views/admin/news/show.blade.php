@extends('layouts.admin')
@section('content')
<div class="admin-card" style="max-width:700px; margin:auto;">
    <h1 style="color:var(--primary-color); margin-bottom:20px;"><i class="fas fa-newspaper"></i> Detalle de Noticia</h1>
    <div style="background:#f8fafc; padding:25px; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07);">
@if($noticia->image)
            <img src="{{ asset('storage/' . $noticia->image) }}" alt="Imagen de la noticia" style="width:100%; max-width:400px; border-radius:8px; margin-bottom:20px;">
        @endif
        <h2 style="color:#764ba2;">{{ $noticia->title }}</h2>
        <p style="color:#555; font-size:1.1rem;">{{ $noticia->content }}</p>
        <p style="margin-top:15px; color:#888;">
            <i class="fas fa-user"></i> {{ $noticia->author }}<br>
            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($noticia->published_at)->format('d/m/Y') }}
        </p>
            <a href="{{ route('admi.news.index') }}" class="btn btn-secondary" style="font-weight:bold; font-size:1rem; padding:10px 20px; border-radius:8px; margin-top:20px;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@endsection
