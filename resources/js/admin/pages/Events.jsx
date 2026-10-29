import React, { useState, useEffect } from 'react';
import { api } from '../utils/api';

export default function Events() {
  const [events, setEvents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchEvents = async () => {
      try {
        console.log('Fetching events...');
        const response = await api.events.getAll();
        console.log('Events response:', response);
        setEvents(response.data.items || response.data || []);
        setError(null);
      } catch (err) {
        console.error('Error fetching events:', err);
        setError('Error al cargar eventos: ' + (err.response?.data?.message || err.message));
      } finally {
        setLoading(false);
      }
    };

    fetchEvents();
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
        <div>Cargando eventos...</div>
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
      <h1>📅 Eventos - Debug Mode</h1>
      
      {error && (
        <div style={{ color: '#ef4444', marginBottom: '1rem' }}>
          Error: {error}
        </div>
      )}
      
      <p>Total de eventos: {events.length}</p>
      
      {events.length > 0 ? (
        <div>
          <h2>Lista de Eventos:</h2>
          {events.map((event, index) => (
            <div key={event.id || index} style={{
              backgroundColor: '#1e293b',
              padding: '1rem',
              marginBottom: '1rem',
              borderRadius: '0.5rem'
            }}>
              <h3>{event.title}</h3>
              <p><strong>Descripción:</strong> {event.description}</p>
              <p><strong>Inicio:</strong> {event.start_time}</p>
              <p><strong>Fin:</strong> {event.end_time}</p>
              <p><strong>Ubicación:</strong> {event.location}</p>
              <p><strong>Destacado:</strong> {event.is_featured ? 'Sí' : 'No'}</p>
            </div>
          ))}
        </div>
      ) : (
        <div>
          <h2>No hay eventos</h2>
          <p>No se encontraron eventos.</p>
        </div>
      )}
      
      <button 
        onClick={() => window.location.reload()}
        style={{
          padding: '0.5rem 1rem',
          backgroundColor: '#3b82f6',
          color: 'white',
          border: 'none',
          borderRadius: '0.25rem',
          cursor: 'pointer',
          marginTop: '1rem'
        }}
      >
        Recargar
      </button>
    </div>
  );
}