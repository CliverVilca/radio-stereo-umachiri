import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function EventsList({ onEdit, onCreate }) {
  const [events, setEvents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    start_date: '',
    end_date: '',
    upcoming_only: false,
    page: 1,
    per_page: 10
  });
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, eventId: null, eventTitle: '' });

  const fetchEvents = async () => {
    try {
      setLoading(true);
      const response = await api.events.getAll(filters);
      setEvents(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar los eventos');
      console.error('Events fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchEvents();
  }, [filters]);

  const handleDeleteClick = (event) => {
    setDeleteDialog({
      isOpen: true,
      eventId: event.id,
      eventTitle: event.title
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.events.delete(deleteDialog.eventId);
      fetchEvents(); // Refresh the list
      setDeleteDialog({ isOpen: false, eventId: null, eventTitle: '' });
    } catch (err) {
      alert('Error al eliminar el evento');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, eventId: null, eventTitle: '' });
  };

  const handleFilterChange = (key, value) => {
    setFilters(prev => ({
      ...prev,
      [key]: value,
      page: 1 // Reset to first page when filtering
    }));
  };

  const handlePageChange = (page) => {
    setFilters(prev => ({ ...prev, page }));
  };

  const formatEventDate = (date, time) => {
    const eventDate = new Date(date);
    const options = { 
      weekday: 'long', 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric' 
    };
    return `${eventDate.toLocaleDateString('es-ES', options)} - ${time}`;
  };

  const isEventUpcoming = (eventDate) => {
    return new Date(eventDate) >= new Date().setHours(0, 0, 0, 0);
  };

  const isEventToday = (eventDate) => {
    const today = new Date().toDateString();
    return new Date(eventDate).toDateString() === today;
  };

  return (
    <div>
      {/* Header */}
      <div style={{ 
        display: 'flex', 
        justifyContent: 'space-between', 
        alignItems: 'center', 
        marginBottom: '2rem' 
      }}>
        <h2 style={{ color: '#16a34a', margin: 0 }}>Lista de Eventos</h2>
        <button
          onClick={onCreate}
          style={{
            backgroundColor: '#16a34a',
            color: 'white',
            border: 'none',
            borderRadius: '8px',
            padding: '0.75rem 1.5rem',
            cursor: 'pointer',
            fontSize: '0.9rem',
            fontWeight: '600',
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem'
          }}
        >
          <i className="fas fa-plus"></i>
          Nuevo Evento
        </button>
      </div>

      {/* Filters */}
      <div style={{
        backgroundColor: '#374151',
        borderRadius: '8px',
        padding: '1rem',
        marginBottom: '1rem',
        display: 'grid',
        gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))',
        gap: '1rem',
        alignItems: 'end'
      }}>
        <div>
          <label style={{ 
            display: 'block', 
            color: '#e5e7eb', 
            fontSize: '0.8rem', 
            marginBottom: '0.25rem' 
          }}>
            Buscar eventos
          </label>
          <input
            type="text"
            placeholder="Buscar por título o ubicación..."
            value={filters.search}
            onChange={(e) => handleFilterChange('search', e.target.value)}
            style={{
              width: '100%',
              backgroundColor: '#1f2937',
              border: '1px solid #4b5563',
              borderRadius: '6px',
              padding: '0.5rem',
              color: '#e5e7eb'
            }}
          />
        </div>
        
        <div>
          <label style={{ 
            display: 'block', 
            color: '#e5e7eb', 
            fontSize: '0.8rem', 
            marginBottom: '0.25rem' 
          }}>
            Fecha desde
          </label>
          <input
            type="date"
            value={filters.start_date}
            onChange={(e) => handleFilterChange('start_date', e.target.value)}
            style={{
              width: '100%',
              backgroundColor: '#1f2937',
              border: '1px solid #4b5563',
              borderRadius: '6px',
              padding: '0.5rem',
              color: '#e5e7eb'
            }}
          />
        </div>

        <div>
          <label style={{ 
            display: 'block', 
            color: '#e5e7eb', 
            fontSize: '0.8rem', 
            marginBottom: '0.25rem' 
          }}>
            Fecha hasta
          </label>
          <input
            type="date"
            value={filters.end_date}
            onChange={(e) => handleFilterChange('end_date', e.target.value)}
            style={{
              width: '100%',
              backgroundColor: '#1f2937',
              border: '1px solid #4b5563',
              borderRadius: '6px',
              padding: '0.5rem',
              color: '#e5e7eb'
            }}
          />
        </div>

        <div style={{ display: 'flex', gap: '0.5rem' }}>
          <label style={{
            display: 'flex',
            alignItems: 'center',
            gap: '0.5rem',
            color: '#e5e7eb',
            fontSize: '0.9rem',
            cursor: 'pointer'
          }}>
            <input
              type="checkbox"
              checked={filters.upcoming_only}
              onChange={(e) => handleFilterChange('upcoming_only', e.target.checked)}
              style={{ accentColor: '#16a34a' }}
            />
            Solo próximos
          </label>
          
          <button
            onClick={() => setFilters({
              search: '',
              start_date: '',
              end_date: '',
              upcoming_only: false,
              page: 1,
              per_page: 10
            })}
            style={{
              backgroundColor: '#6b7280',
              color: 'white',
              border: 'none',
              borderRadius: '6px',
              padding: '0.5rem 1rem',
              cursor: 'pointer',
              fontSize: '0.8rem'
            }}
          >
            Limpiar
          </button>
        </div>
      </div>

      {/* Loading State */}
      {loading && (
        <div style={{ 
          textAlign: 'center', 
          color: '#94a3b8', 
          padding: '3rem',
          backgroundColor: '#1f2937',
          borderRadius: '8px'
        }}>
          <i className="fas fa-spinner fa-spin" style={{ fontSize: '2rem', marginBottom: '1rem' }}></i>
          <p>Cargando eventos...</p>
        </div>
      )}

      {/* Error State */}
      {error && (
        <div style={{ 
          backgroundColor: '#ef4444', 
          color: 'white', 
          padding: '1rem', 
          borderRadius: '8px',
          marginBottom: '1rem'
        }}>
          <i className="fas fa-exclamation-triangle" style={{ marginRight: '0.5rem' }}></i>
          {error}
        </div>
      )}

      {/* Events List */}
      {!loading && !error && (
        <>
          <div style={{
            backgroundColor: '#1f2937',
            borderRadius: '8px',
            overflow: 'hidden'
          }}>
            {events.length === 0 ? (
              <div style={{ 
                textAlign: 'center', 
                color: '#94a3b8', 
                padding: '3rem' 
              }}>
                <i className="fas fa-calendar-alt" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
                <p>No se encontraron eventos</p>
                <button
                  onClick={onCreate}
                  style={{
                    backgroundColor: '#16a34a',
                    color: 'white',
                    border: 'none',
                    borderRadius: '6px',
                    padding: '0.5rem 1rem',
                    cursor: 'pointer',
                    marginTop: '1rem'
                  }}
                >
                  Crear primer evento
                </button>
              </div>
            ) : (
              <div style={{ overflowX: 'auto' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                  <thead>
                    <tr style={{ backgroundColor: '#374151' }}>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Evento
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Fecha y Hora
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Ubicación
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Estado
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'center', color: '#e5e7eb', fontWeight: '600' }}>
                        Acciones
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {events.map((event, index) => (
                      <tr 
                        key={event.id}
                        style={{ 
                          borderBottom: '1px solid #374151',
                          backgroundColor: index % 2 === 0 ? '#1f2937' : '#111827'
                        }}
                      >
                        <td style={{ padding: '1rem' }}>
                          <div>
                            <div style={{ 
                              color: '#e5e7eb', 
                              fontWeight: '600', 
                              marginBottom: '0.25rem',
                              display: 'flex',
                              alignItems: 'center',
                              gap: '0.5rem'
                            }}>
                              {truncateText(event.title, 50)}
                              {event.is_featured && (
                                <span style={{
                                  backgroundColor: '#f59e0b',
                                  color: 'white',
                                  padding: '0.125rem 0.375rem',
                                  borderRadius: '4px',
                                  fontSize: '0.7rem',
                                  fontWeight: '600'
                                }}>
                                  <i className="fas fa-star" style={{ marginRight: '0.25rem' }}></i>
                                  Destacado
                                </span>
                              )}
                              {isEventToday(event.event_date) && (
                                <span style={{
                                  backgroundColor: '#ef4444',
                                  color: 'white',
                                  padding: '0.125rem 0.375rem',
                                  borderRadius: '4px',
                                  fontSize: '0.7rem',
                                  fontWeight: '600'
                                }}>
                                  HOY
                                </span>
                              )}
                            </div>
                            {event.description && (
                              <div style={{ 
                                color: '#9ca3af', 
                                fontSize: '0.8rem' 
                              }}>
                                {truncateText(event.description, 80)}
                              </div>
                            )}
                          </div>
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <div style={{ color: '#d1d5db', fontSize: '0.9rem' }}>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.25rem' }}>
                              <i className="fas fa-calendar" style={{ color: '#16a34a', fontSize: '0.8rem' }}></i>
                              {new Date(event.event_date).toLocaleDateString('es-ES')}
                            </div>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                              <i className="fas fa-clock" style={{ color: '#2563eb', fontSize: '0.8rem' }}></i>
                              {event.event_time}
                            </div>
                          </div>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db' }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <i className="fas fa-map-marker-alt" style={{ color: '#ef4444', fontSize: '0.8rem' }}></i>
                            {truncateText(event.location, 30)}
                          </div>
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <span style={{
                            backgroundColor: isEventUpcoming(event.event_date) ? '#16a34a' : '#6b7280',
                            color: 'white',
                            padding: '0.25rem 0.5rem',
                            borderRadius: '4px',
                            fontSize: '0.75rem',
                            fontWeight: '600'
                          }}>
                            {isEventUpcoming(event.event_date) ? 'Próximo' : 'Pasado'}
                          </span>
                        </td>
                        <td style={{ padding: '1rem', textAlign: 'center' }}>
                          <div style={{ display: 'flex', gap: '0.5rem', justifyContent: 'center' }}>
                            <button
                              onClick={() => onEdit(event)}
                              style={{
                                backgroundColor: '#2563eb',
                                color: 'white',
                                border: 'none',
                                borderRadius: '4px',
                                padding: '0.5rem',
                                cursor: 'pointer',
                                fontSize: '0.8rem'
                              }}
                              title="Editar"
                            >
                              <i className="fas fa-edit"></i>
                            </button>
                            <button
                              onClick={() => handleDeleteClick(event)}
                              style={{
                                backgroundColor: '#ef4444',
                                color: 'white',
                                border: 'none',
                                borderRadius: '4px',
                                padding: '0.5rem',
                                cursor: 'pointer',
                                fontSize: '0.8rem'
                              }}
                              title="Eliminar"
                            >
                              <i className="fas fa-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>

          {/* Pagination */}
          {pagination && pagination.last_page > 1 && (
            <div style={{
              display: 'flex',
              justifyContent: 'space-between',
              alignItems: 'center',
              marginTop: '1rem',
              padding: '1rem',
              backgroundColor: '#1f2937',
              borderRadius: '8px'
            }}>
              <div style={{ color: '#9ca3af', fontSize: '0.9rem' }}>
                Mostrando {pagination.from} a {pagination.to} de {pagination.total} resultados
              </div>
              <div style={{ display: 'flex', gap: '0.5rem' }}>
                <button
                  onClick={() => handlePageChange(pagination.current_page - 1)}
                  disabled={pagination.current_page === 1}
                  style={{
                    backgroundColor: pagination.current_page === 1 ? '#4b5563' : '#6b7280',
                    color: 'white',
                    border: 'none',
                    borderRadius: '4px',
                    padding: '0.5rem 1rem',
                    cursor: pagination.current_page === 1 ? 'not-allowed' : 'pointer',
                    fontSize: '0.8rem'
                  }}
                >
                  Anterior
                </button>
                <span style={{ 
                  color: '#e5e7eb', 
                  padding: '0.5rem 1rem',
                  fontSize: '0.9rem'
                }}>
                  Página {pagination.current_page} de {pagination.last_page}
                </span>
                <button
                  onClick={() => handlePageChange(pagination.current_page + 1)}
                  disabled={pagination.current_page === pagination.last_page}
                  style={{
                    backgroundColor: pagination.current_page === pagination.last_page ? '#4b5563' : '#6b7280',
                    color: 'white',
                    border: 'none',
                    borderRadius: '4px',
                    padding: '0.5rem 1rem',
                    cursor: pagination.current_page === pagination.last_page ? 'not-allowed' : 'pointer',
                    fontSize: '0.8rem'
                  }}
                >
                  Siguiente
                </button>
              </div>
            </div>
          )}
        </>
      )}

      {/* Delete Confirmation Dialog */}
      <ConfirmDialog
        isOpen={deleteDialog.isOpen}
        onClose={handleDeleteCancel}
        onConfirm={handleDeleteConfirm}
        title="Eliminar Evento"
        message={`¿Estás seguro de que quieres eliminar el evento "${deleteDialog.eventTitle}"? Esta acción no se puede deshacer.`}
        confirmText="Eliminar"
        cancelText="Cancelar"
        type="danger"
      />
    </div>
  );
}