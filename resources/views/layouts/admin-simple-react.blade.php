<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Admin - Radio Stereo Umachiri</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
        }
        #admin-root { min-height: 100vh; }
        .loading { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
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
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div id="admin-root">
        <div class="loading">
            <div class="spinner"></div>
            <div>Cargando Panel Admin...</div>
        </div>
    </div>

    @vite(['resources/js/admin/main.jsx'])
    
    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
        console.log('🚀 Admin Panel loading...');
    </script>
</body>
</html>