<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Panel de Administración</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="margin: 0; padding: 0;">
    <div id="admin-root"></div>
    
    <script type="module">
        import React from 'react';
        import { createRoot } from 'react-dom/client';

        console.log('Inline test script loading...');

        function TestApp() {
            return React.createElement('div', {
                style: { 
                    padding: '2rem', 
                    backgroundColor: '#1f2937', 
                    color: 'white', 
                    minHeight: '100vh',
                    fontFamily: 'Arial, sans-serif'
                }
            }, [
                React.createElement('h1', { 
                    key: 'title',
                    style: { color: '#ef4444' } 
                }, '🎉 React está funcionando!'),
                React.createElement('p', { key: 'desc' }, 'Si ves este mensaje, React se está cargando correctamente.'),
                React.createElement('div', {
                    key: 'status',
                    style: { 
                        backgroundColor: '#374151', 
                        padding: '1rem', 
                        borderRadius: '8px',
                        marginTop: '1rem'
                    }
                }, [
                    React.createElement('h2', { key: 'status-title' }, 'Estado del Sistema:'),
                    React.createElement('ul', { key: 'status-list' }, [
                        React.createElement('li', { key: 'react' }, '✅ React: Funcionando'),
                        React.createElement('li', { key: 'vite' }, '✅ Vite: Compilado'),
                        React.createElement('li', { key: 'laravel' }, '✅ Laravel: Activo')
                    ])
                ]),
                React.createElement('button', {
                    key: 'button',
                    onClick: () => alert('¡El JavaScript está funcionando!'),
                    style: {
                        backgroundColor: '#2563eb',
                        color: 'white',
                        border: 'none',
                        padding: '0.75rem 1.5rem',
                        borderRadius: '6px',
                        cursor: 'pointer',
                        marginTop: '1rem',
                        fontSize: '1rem'
                    }
                }, 'Probar JavaScript')
            ]);
        }

        // Mount the test app
        const container = document.getElementById('admin-root');
        if (container) {
            const root = createRoot(container);
            root.render(React.createElement(TestApp));
            console.log('Test app mounted successfully!');
        } else {
            console.error('Could not find admin-root container!');
        }
    </script>
    
    <script type="module" src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script type="module" src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
</body>
</html>