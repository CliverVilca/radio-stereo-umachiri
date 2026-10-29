@extends('layouts.admin')

@section('title', 'Programas')

@section('content')
<div class="admin-card">
    <h1 style="margin: 0 0 20px 0; color: var(--primary-color);">📻 Programas de Radio</h1>
    <p style="color: var(--text-light); margin-bottom: 30px;">Gestiona la programación de Radio Stereo Umachiri</p>
</div>

<div class="admin-card">
    <h3 style="margin: 0 0 15px 0; color: var(--primary-color);">Lista de Programas</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background: var(--bg-light);">
                <th style="padding: 10px; text-align: left;">#</th>
                <th style="padding: 10px; text-align: left;">Nombre</th>
                <th style="padding: 10px; text-align: left;">Conductor</th>
                <th style="padding: 10px; text-align: left;">Horario</th>
                <th style="padding: 10px; text-align: left;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($programs as $program)
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 10px;">{{ $program['id'] }}</td>
                <td style="padding: 10px;">{{ $program['name'] }}</td>
                <td style="padding: 10px;">{{ $program['host'] }}</td>
                <td style="padding: 10px;">{{ $program['time'] }}</td>
                <td style="padding: 10px;">
                    @if($program['status'] === 'live')
                        <span style="background: var(--success-color); color: white; padding: 2px 8px; border-radius: 15px; font-size: 0.9rem;">En Vivo</span>
                    @else
                        <span style="background: var(--accent-color); color: white; padding: 2px 8px; border-radius: 15px; font-size: 0.9rem;">Próximo</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection