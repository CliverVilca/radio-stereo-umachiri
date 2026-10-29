@extends('layouts.app')

@section('title', 'Página no encontrada - Stereo Umachiri')

@section('content')
<div class="error-container position-relative overflow-hidden d-flex align-items-center justify-content-center" style="min-height: 80vh; background: #0f172a;">
    
    <!-- Background Noise Animation -->
    <div class="noise-overlay position-absolute w-100 h-100 top-0 start-0" style="opacity: 0.05; pointer-events: none; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyBAMAAADsEZWCAAAAGFBMVEUAAAA5OTkAAABMTExERERQUFBFRUUAAAB3Zj+lAAAACHRSTlMAMwAzzP///VrE7QEAAAAJcEhZcwAADsQAAA7EAZUrDhsAAABDSURBVDjLY2AYBaNgFIyCUTAKRsEoGAWjYBSMglEwCkbBKBgFo2AUjIJRMApGwSgYBaNgFIyCUTAKRsEoGAWjYBSMAgANIwPHBwe3yAAAAABJRU5ErkJggg=='); animation: noise 0.5s steps(8) infinite;"></div>

    <div class="text-center position-relative z-index-1 p-4">
        <div class="mb-4 position-relative d-inline-block">
            <h1 class="display-1 fw-bold text-white glitch" data-text="404" style="font-size: 8rem; letter-spacing: -5px; text-shadow: 4px 4px 0px #ef4444, -4px -4px 0px #22c55e;">
                404
            </h1>
            <div class="position-absolute top-50 start-50 translate-middle w-100 h-2 bg-danger" style="opacity: 0.5; filter: blur(4px);"></div>
        </div>
        
        <h2 class="h2 text-white mb-3 fw-bold">¡Señal Interrumpida!</h2>
        <p class="lead text-white-50 mb-5 mx-auto" style="max-width: 500px;">
            Parece que la frecuencia que buscas no está disponible o ha sido movida. Regresemos a la programación habitual.
        </p>

        <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg hover-lift" style="background: linear-gradient(135deg, #15803d 0%, #166534 100%); border: none;">
            <i class="fas fa-broadcast-tower me-2"></i> Volver al Aire
        </a>
    </div>

    <!-- Animated Equalizer Bars (Decorative) -->
    <div class="equalizer-container position-absolute bottom-0 start-0 w-100 d-flex justify-content-center align-items-end gap-1 px-5" style="height: 100px; opacity: 0.2;">
        @for($i = 0; $i < 40; $i++)
            <div class="bar bg-success rounded-top" style="width: 10px; height: {{ rand(20, 100) }}%; animation: equalize {{ rand(500, 1500) }}ms infinite ease-in-out alternate;"></div>
        @endfor
    </div>
</div>

<style>
    @keyframes noise {
        0% { transform: translate(0,0) }
        10% { transform: translate(-5%,-5%) }
        20% { transform: translate(-10%,5%) }
        30% { transform: translate(5%,-10%) }
        40% { transform: translate(-5%,15%) }
        50% { transform: translate(-10%,5%) }
        60% { transform: translate(15%,0) }
        70% { transform: translate(0,10%) }
        80% { transform: translate(-15%,0) }
        90% { transform: translate(10%,5%) }
        100% { transform: translate(5%,0) }
    }

    @keyframes equalize {
        0% { height: 10%; }
        100% { height: 100%; }
    }

    .glitch {
        position: relative;
    }
    
    .glitch::before,
    .glitch::after {
        content: attr(data-text);
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #0f172a;
    }
    
    .glitch::before {
        left: 2px;
        text-shadow: -2px 0 #ff00c1;
        clip: rect(44px, 450px, 56px, 0);
        animation: glitch-anim 5s infinite linear alternate-reverse;
    }
    
    .glitch::after {
        left: -2px;
        text-shadow: -2px 0 #00fff9;
        clip: rect(44px, 450px, 56px, 0);
        animation: glitch-anim2 5s infinite linear alternate-reverse;
    }
    
    @keyframes glitch-anim {
        0% { clip: rect(38px, 9999px, 81px, 0); }
        5% { clip: rect(66px, 9999px, 19px, 0); }
        10% { clip: rect(6px, 9999px, 98px, 0); }
        15% { clip: rect(82px, 9999px, 5px, 0); }
        20% { clip: rect(26px, 9999px, 60px, 0); }
        25% { clip: rect(87px, 9999px, 93px, 0); }
        30% { clip: rect(10px, 9999px, 55px, 0); }
        35% { clip: rect(98px, 9999px, 73px, 0); }
        40% { clip: rect(48px, 9999px, 97px, 0); }
        45% { clip: rect(18px, 9999px, 8px, 0); }
        50% { clip: rect(40px, 9999px, 14px, 0); }
        55% { clip: rect(6px, 9999px, 72px, 0); }
        60% { clip: rect(25px, 9999px, 96px, 0); }
        65% { clip: rect(68px, 9999px, 35px, 0); }
        70% { clip: rect(13px, 9999px, 3px, 0); }
        75% { clip: rect(58px, 9999px, 66px, 0); }
        80% { clip: rect(96px, 9999px, 17px, 0); }
        85% { clip: rect(11px, 9999px, 56px, 0); }
        90% { clip: rect(81px, 9999px, 98px, 0); }
        95% { clip: rect(51px, 9999px, 18px, 0); }
        100% { clip: rect(20px, 9999px, 20px, 0); }
    }
    
    @keyframes glitch-anim2 {
        0% { clip: rect(19px, 9999px, 83px, 0); }
        5% { clip: rect(56px, 9999px, 7px, 0); }
        10% { clip: rect(83px, 9999px, 95px, 0); }
        15% { clip: rect(72px, 9999px, 32px, 0); }
        20% { clip: rect(63px, 9999px, 3px, 0); }
        25% { clip: rect(28px, 9999px, 59px, 0); }
        30% { clip: rect(96px, 9999px, 2px, 0); }
        35% { clip: rect(76px, 9999px, 36px, 0); }
        40% { clip: rect(31px, 9999px, 54px, 0); }
        45% { clip: rect(23px, 9999px, 90px, 0); }
        50% { clip: rect(11px, 9999px, 45px, 0); }
        55% { clip: rect(98px, 9999px, 58px, 0); }
        60% { clip: rect(8px, 9999px, 25px, 0); }
        65% { clip: rect(75px, 9999px, 96px, 0); }
        70% { clip: rect(34px, 9999px, 52px, 0); }
        75% { clip: rect(55px, 9999px, 3px, 0); }
        80% { clip: rect(76px, 9999px, 68px, 0); }
        85% { clip: rect(15px, 9999px, 95px, 0); }
        90% { clip: rect(52px, 9999px, 29px, 0); }
        95% { clip: rect(85px, 9999px, 16px, 0); }
        100% { clip: rect(28px, 9999px, 87px, 0); }
    }
</style>
@endsection
