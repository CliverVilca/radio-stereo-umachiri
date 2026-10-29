<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administración - Radio Stereo Umachiri</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin-responsive.css') }}">
    
    <!-- Vite Assets -->
    @vite(['resources/js/admin/main.jsx'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
            overflow-x: hidden;
        }
        
        #admin-root {
            min-height: 100vh;
            width: 100%;
        }
        
        /* Loading spinner */
        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #0f172a;
            flex-direction: column;
        }
        
        .spinner {
            border: 4px solid #374151;
            border-top: 4px solid #ef4444;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin-bottom: 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading-text {
            color: #94a3b8;
            font-size: 1.1rem;
        }
        
        /* Error styles */
        .error-container {
            padding: 2rem;
            background: #ef4444;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .error-container h1 {
            margin-bottom: 1rem;
            font-size: 2rem;
        }
        
        .error-container p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        
        .error-container button {
            background: white;
            color: #ef4444;
            border: none;
            padding: 1rem 2rem;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 1rem;
            font-weight: bold;
            font-size: 1rem;
        }
        
        .error-container button:hover {
            background: #f3f4f6;
        }
    </style>
</head>
<body>
    <div id="admin-root">
        <div class="loading-container">
            <div class="spinner"></div>
            <div class="loading-text">Cargando Panel de Administración...</div>
        </div>
    </div>

    <script>
        // Global error handler
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
            const container = document.getElementById('admin-root');
            if (container && !container.querySelector('.admin-app')) {
                container.innerHTML = `
                    <div class="error-container">
                        <h1>❌ Error cargando el Panel Admin</h1>
                        <p><strong>Error:</strong> ${e.message}</p>
                        <p>Verifica tu conexión a internet y recarga la página.</p>
                        <button onclick="window.location.reload()">🔄 Recargar Página</button>
                    </div>
                `;
            }
        });

        // Set up CSRF token for API requests
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
        
        // Debug info
        console.log('🚀 Admin Panel initializing...');
        console.log('📍 Current URL:', window.location.href);
        console.log('🔑 CSRF Token:', window.Laravel.csrfToken);
    </script>
</body>
</html>