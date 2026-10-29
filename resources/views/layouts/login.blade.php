<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Iniciar sesión - Radio Stereo Umachiri">
    <meta name="keywords" content="login, radio, stereo, umachiri">
    <meta name="author" content="Stereo Umachiri">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Iniciar Sesión - Stereo Umachiri</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Login CSS -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- Meta tags for PWA -->
    <meta name="theme-color" content="#dc2626">
    <meta name="mobile-web-app-capable" content="yes">
</head>
<body class="login-body">
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
