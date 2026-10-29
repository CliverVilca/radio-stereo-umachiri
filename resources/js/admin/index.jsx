// React Admin Panel for Radio Stereo Umachiri
import React from 'react';
import { createRoot } from 'react-dom/client';

console.log('🚀 Admin Panel - Radio Stereo Umachiri');

// Import the main App component
import App from './App.jsx';

// Mount function with error handling
function mountApp() {
    try {
        const container = document.getElementById('admin-root');
        if (container) {
            console.log('✅ Mounting Admin Panel...');
            
            // Clear any existing content
            container.innerHTML = '';
            
            // Create root and render
            const root = createRoot(container);
            root.render(React.createElement(App));
            
            console.log('✅ Admin Panel loaded successfully!');
        } else {
            console.error('❌ Could not find admin-root container!');
        }
    } catch (error) {
        console.error('❌ Error mounting Admin Panel:', error);
        
        // Fallback: show error message
        const container = document.getElementById('admin-root') || document.body;
        container.innerHTML = `
            <div style="padding: 2rem; background: #ef4444; color: white; font-family: Arial, sans-serif; text-align: center;">
                <h1>❌ Error cargando el Panel Admin</h1>
                <p><strong>Error:</strong> ${error.message}</p>
                <p>Por favor, recarga la página o contacta al administrador.</p>
                <button onclick="window.location.reload()" style="
                    background: white; 
                    color: #ef4444; 
                    border: none; 
                    padding: 1rem 2rem; 
                    border-radius: 6px; 
                    cursor: pointer; 
                    margin-top: 1rem;
                    font-weight: bold;
                ">
                    🔄 Recargar Página
                </button>
            </div>
        `;
    }
}

// Mount when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountApp);
} else {
    mountApp();
}