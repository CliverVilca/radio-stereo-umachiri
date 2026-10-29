import React, { useState, useEffect } from 'react';
import { api } from '../utils/api';

export default function Sports() {
  const [sports, setSports] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchSports = async () => {
      try {
        console.log('Fetching sports...');
        const response = await api.sports.getAll();
        console.log('Sports response:', response);
        setSports(response.data.items || response.data || []);
        setError(null);
      } catch (err) {
        console.error('Error fetching sports:', err);
        setError('Error al cargar deportes: ' + (err.response?.data?.message || err.message));
      } finally {
        setLoading(false);
      }
    };

    fetchSports();
  }, []);

  if (loading) {
    return (
      <div style={{ 
        minHeight: '100vh',
        backgroundColor: '#0f172a',
        color: '#e2e8f0',
        padding: '2rem',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center'
      }}>
        <div>Cargando deportes...</div>
      </div>
    );
  }

  if (error) {
    return (
      <div style={{ 
        minHeight: '100vh',
        backgroundColor: '#0f172a',
        color: '#e2e8f0',
        padding: '2rem'
      }}>
        <h1>🏆 Deportes - Debug</h1>
        <div style={{ color: '#ef4444', marginBottom: '1rem' }}>
          Error: {error}
        </div>
        <button 
          onClick={() => window.location.reload()}
          style={{
            padding: '0.5rem 1rem',
            backgroundColor: '#3b82f6',
            color: 'white',
            border: 'none',
            borderRadius: '0.25rem',
            cursor: 'pointer'
          }}
        >
          Recargar
        </button>
      </div>
    );
  }

  return (
    <div style={{ 
      minHeight: '100vh',
      backgroundColor: '#0f172a',
      color: '#e2e8f0',
      padding: '2rem'
    }}>
      <h1>🏆 Deportes - Debug Mode</h1>
      <p>Total de deportes: {sports.length}</p>
      
      {sports.length > 0 ? (
        <div>
          <h2>Lista de Deportes:</h2>
          {sports.map((sport, index) => (
            <div key={sport.id || index} style={{
              backgroundColor: '#1e293b',
              padding: '1rem',
              marginBottom: '1rem',
              borderRadius: '0.5rem'
            }}>
              <h3>{sport.title}</h3>
              <p><strong>Autor:</strong> {sport.author}</p>
              <p><strong>Categoría:</strong> {sport.category}</p>
              <p><strong>Estado:</strong> {sport.status}</p>
              <p><strong>Destacado:</strong> {sport.is_featured ? 'Sí' : 'No'}</p>
              <p><strong>Fecha:</strong> {sport.published_at}</p>
            </div>
          ))}
        </div>
      ) : (
        <div>
          <h2>No hay deportes</h2>
          <p>No se encontraron noticias deportivas.</p>
        </div>
      )}
    </div>
  );
}