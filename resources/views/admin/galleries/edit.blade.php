@extends('layouts.admin')

@section('content')
    <h1>Editar Imagen de la Galería</h1>
    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" name="title" class="form-control" value="{{ $gallery->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea name="description" class="form-control">{{ $gallery->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Imagen (opcional)</label>
            <input type="file" name="image" class="form-control">
            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" width="100" class="mt-2">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
@endsection
