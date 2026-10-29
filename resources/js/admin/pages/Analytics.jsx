import React from 'react';
import Layout from '../components/Layout';

export default function Analytics() {
  return (
    <Layout 
      title="📊 Analytics" 
      subtitle="Estadísticas y métricas de Radio Stereo Umachiri"
      color="#f59e0b"
    >
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: '2rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
      }}>
        <h2 style={{ color: '#f59e0b', marginBottom: '1rem' }}>Métricas del Sitio</h2>
        <p style={{ color: '#fcd34d', marginBottom: '1rem' }}>Aquí se mostrarán las estadísticas y métricas del sitio web.</p>
        
        <div style={{ display: 'flex', gap: '1rem', marginBottom: '2rem' }}>
          <button style={{
            backgroundColor: '#f59e0b',
            color: 'white',
            border: 'none',
            borderRadius: '8px',
            padding: '0.75rem 1.5rem',
            cursor: 'pointer',
            fontSize: '0.9rem',
            fontWeight: '600'
          }}>
            Generar Reporte
          </button>
          <button style={{
            backgroundColor: '#6b7280',
            color: 'white',
            border: 'none',
            borderRadius: '8px',
            padding: '0.75rem 1.5rem',
            cursor: 'pointer',
            fontSize: '0.9rem',
            fontWeight: '600'
          }}>
            Filtrar Fechas
          </button>
        </div>
        
        <div style={{
          backgroundColor: '#374151',
          borderRadius: '8px',
          padding: '1rem',
          color: '#d1d5db'
        }}>
          <p>📈 Gráficos y estadísticas aparecerán aquí</p>
          <p style={{ fontSize: '0.8rem', marginTop: '0.5rem', color: '#9ca3af' }}>
            Funcionalidad completa se implementará en las siguientes tareas
          </p>
        </div>
      </div>
    </Layout>
  );
}
