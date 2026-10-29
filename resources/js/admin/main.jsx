import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './App.jsx';

// Simple React app entry point
const container = document.getElementById('admin-root');
if (container) {
    const root = createRoot(container);
    root.render(<App />);
} else {
    console.error('Container not found');
}