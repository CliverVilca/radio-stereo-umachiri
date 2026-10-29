@extends('layouts.admin')

@section('title', 'Editar Programa')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Editar Programa</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Título del Programa</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $program->title) }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $program->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="host">Conductor</label>
                    <input type="text" name="host" id="host" class="form-control" value="{{ old('host', $program->host) }}" required>
                </div>
                <div class="form-group">
                    <label>Días de la Semana</label>
                    <div>
                        @foreach($days as $day)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="days_of_week[]" id="day_{{ $day }}" value="{{ $day }}" {{ in_array($day, old('days_of_week', $program->days_of_week ?? [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_time">Hora de Inicio</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $program->start_time) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_time">Hora de Fin</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $program->end_time) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">Imagen del Programa</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" alt="Imagen actual" class="img-thumbnail mt-2" width="200">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Programa</button>
            </form>
        </div>
    </div>
</div>
@endsection
