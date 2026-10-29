<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Admin Panel - ARREGLADO</title>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 1000px; 
            margin: 0 auto; 
            padding: 20px; 
            background: #1f2937;
            color: white;
        }
        .test { 
            margin: 20px 0; 
            padding: 20px; 
            border: 2px solid #374151; 
            border-radius: 10px; 
            background: #111827;
        }
        .success { 
            background: #065f46; 
            border-color: #10b981; 
        }
        .error { 
            background: #7f1d1d; 
            border-color: #ef4444; 
        }
        button { 
            background: #ef4444; 
            color: white; 
            border: none; 
            padding: 12px 24px; 
            border-radius: 6px; 
            cursor: pointer; 
            margin-right: 10px;
        }
        button:hover { background: #dc2626; }
        .result { 
            margin-top: 15px; 
            padding: 15px; 
            background: #374151; 
            border-radius: 6px; 
            font-family: monospace;
            white-space: pre-wrap;
        }
        .admin-link {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 10px;
        }
        .admin-link:hover {
            background: #2563eb;
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <h1>🔧 Test Admin Panel - SISTEMA ARREGLADO</h1>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="/admin" class="admin-link">🚀 IR AL PANEL ADMIN</a>
    </div>
    
    <div class="test" id="test-api">
        <h3>1. Test API Arreglada</h3>
        <button onclick="testAPI()">Probar API</button>
        <div id="api-result" class="result" style="display: none;"></div>
    </div>

    <div class="test" id="test-create">
        <h3>2. Test Crear Noticia</h3>
        <button onclick="testCreateNews()">Crear Noticia</button>
        <div id="create-result" class="result" style="display: none;"></div>
    </div>

    <script>
        // Get CSRF token
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        async function testAPI() {
            const result = document.getElementById('api-result');
            const section = document.getElementById('test-api');
            result.style.display = 'block';
            result.textContent = '🔄 Probando API arreglada...';
            
            try {
                // Test dashboard stats
                const response = await fetch('/admin/api/dashboard/stats', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCSRFToken()
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    result.textContent = `✅ API FUNCIONANDO CORRECTAMENTE!

📊 Estadísticas:
- Noticias: ${data.data.news_count}
- Deportes: ${data.data.sports_count}
- Eventos: ${data.data.events_count}
- Programas: ${data.data.programs_count}
- Galerías: ${data.data.galleries_count}
- DJs: ${data.data.djs_count}
- Comentarios: ${data.data.comments_count}

🎉 El panel admin está listo para usar!`;
                    section.className = 'test success';
                } else {
                    throw new Error('API no exitosa: ' + JSON.stringify(data));
                }
                
            } catch (error) {
                result.textContent = `❌ Error: ${error.message}`;
                section.className = 'test error';
            }
        }

        async function testCreateNews() {
            const result = document.getElementById('create-result');
            const section = document.getElementById('test-create');
            result.style.display = 'block';
            result.textContent = '🔄 Creando noticia de prueba...';
            
            try {
                const newsData = {
                    title: `Noticia de Prueba ARREGLADA ${new Date().toLocaleString()}`,
                    content: 'Esta noticia fue creada con el sistema ARREGLADO. Ahora el panel admin funciona perfectamente.',
                    author: 'Sistema Arreglado',
                    type: 'local',
                    status: 'published',
                    published_at: new Date().toISOString().slice(0, 16)
                };

                const response = await fetch('/admin/api/news', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCSRFToken()
                    },
                    body: JSON.stringify(newsData)
                });

                const data = await response.json();
                
                if (data.success) {
                    result.textContent = `✅ ¡NOTICIA CREADA EXITOSAMENTE!

📰 Detalles:
- ID: ${data.data.id}
- Título: ${data.data.title}
- Autor: ${data.data.author}
- Estado: ${data.data.status}
- Tipo: ${data.data.type}

🎊 ¡El sistema está funcionando perfectamente!
Ahora puedes usar el panel admin sin problemas.`;
                    section.className = 'test success';
                } else {
                    throw new Error('Error creando noticia: ' + JSON.stringify(data));
                }
                
            } catch (error) {
                result.textContent = `❌ Error: ${error.message}`;
                section.className = 'test error';
            }
        }

        // Auto-test
        window.onload = function() {
            setTimeout(testAPI, 1000);
        };
    </script>
</body>
</html>