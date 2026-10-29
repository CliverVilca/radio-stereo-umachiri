import React from 'react';
import { createRoot } from 'react-dom/client';

console.log('Test file loading...');

function TestApp() {
  return (
    <div style={{ 
      padding: '2rem', 
      backgroundColor: '#1f2937', 
      color: 'white', 
      minHeight: '100vh',
      fontFamily: 'Arial, sans-serif'
    }}>
      <h1 style={{ color: '#ef4444' }}>🎉 React está funcionando!</h1>
      <p>Si ves este mensaje, React se está cargando correctamente.</p>
      <div style={{ 
        backgroundColor: '#374151', 
        padding: '1rem', 
        borderRadius: '8px',
        marginTop: '1rem'
      }}>
        <h2>Estado del Sistema:</h2>
        <ul>
          <li>✅ React: Funcionando</li>
          <li>✅ Vite: Compilado</li>
          <li>✅ Laravel: Activo</li>
        </ul>
      </div>
      <button 
        onClick={() => alert('¡El JavaScript está funcionando!')}
        style={{
          backgroundColor: '#2563eb',
          color: 'white',
          border: 'none',
          padding: '0.75rem 1.5rem',
          borderRadius: '6px',
          cursor: 'pointer',
          marginTop: '1rem',
          fontSize: '1rem'
        }}
      >
        Probar JavaScript
      </button>
    </div>
  );
}

// Mount the test app
const container = document.getElementById('admin-root');
if (container) {
  const root = createRoot(container);
  root.render(<TestApp />);
  console.log('Test app mounted successfully!');
} else {
  console.error('Could not find admin-root container!');
}