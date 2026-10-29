@extends('layouts.admin')

@section('title', 'Detalle de Noticia de Deportes')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">{{ $sport->title }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($sport->image)
                <img src="{{ asset('storage/' . $sport->image) }}" class="img-fluid rounded mb-4" alt="{{ $sport->title }}">
            @endif
            <p><strong>Autor:</strong> {{ $sport->author }}</p>
            <p><strong>Fecha de Publicación:</strong> {{ $sport->published_at->format('d/m/Y') }}</p>
            <hr>
            <div>
                {!! nl2br(e($sport->content)) !!}
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.sports.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection
