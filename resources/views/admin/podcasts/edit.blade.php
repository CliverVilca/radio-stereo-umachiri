@extends('layouts.admin')

@section('content')
    <h1>Editar Podcast de {{ $program->title }}</h1>
    <form action="{{ route('admin.programs.podcasts.update', [$program, $podcast]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" class="form-control" value="{{ $podcast->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control">{{ $podcast->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="audio">Archivo de Audio (opcional)</label>
            <input type="file" name="audio" class="form-control">
            <audio controls class="mt-2">
                <source src="{{ asset('storage/' . $podcast->audio_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
