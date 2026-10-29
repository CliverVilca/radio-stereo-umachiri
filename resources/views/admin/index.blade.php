<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Radio Stereo Umachiri</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
            background-color: #121212;
            color: #e0e7ff;
        }
        
        #admin-root {
            min-height: 100vh;
        }
        
        .loading-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #1f2937;
            color: #e5e7eb;
            flex-direction: column;
            gap: 1rem;
        }
        
        .spinner {
            border: 4px solid #374151;
            border-top: 4px solid #ef4444;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="admin-root">
        <div class="loading-screen">
            <div class="spinner"></div>
            <h2>Cargando Panel de Administración...</h2>
            <p>Radio Stereo Umachiri</p>
        </div>
    </div>
    
    <!-- Error fallback -->
    <script>
        // Show error after 10 seconds if React doesn't load
        setTimeout(function() {
            const root = document.getElementById('admin-root');
            if (root && root.innerHTML.includes('loading-screen')) {
                root.innerHTML = `
                    <div style="padding: 2rem; background: #ef4444; color: white; text-align: center;">
                        <h1>⚠️ Error cargando el Panel Admin</h1>
                        <p>El panel de administración no se pudo cargar correctamente.</p>
                        <p><strong>Posibles soluciones:</strong></p>
                        <ul style="text-align: left; max-width: 500px; margin: 0 auto;">
                            <li>Recarga la página (F5)</li>
                            <li>Verifica que el servidor esté funcionando</li>
                            <li>Compila los assets: <code>npm run build</code></li>
                            <li>Limpia el cache: <code>php artisan config:clear</code></li>
                        </ul>
                    </div>
                `;
            }
        }, 10000);
    </script>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/admin/main.jsx'])
</body>
</html>