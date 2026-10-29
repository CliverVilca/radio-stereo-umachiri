import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function ProgramsList({ onEdit, onCreate, onManagePodcasts }) {
  const [programs, setPrograms] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    day: '',
    featured: '',
    page: 1,
    per_page: 10
  });
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, programId: null, programTitle: '' });

  const daysOfWeek = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

  const fetchPrograms = async () => {
    try {
      setLoading(true);
      const response = await api.programs.getAll(filters);
      setPrograms(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar los programas');
      console.error('Programs fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPrograms();
  }, [filters]);

  const handleDeleteClick = (program) => {
    setDeleteDialog({
      isOpen: true,
      programId: program.id,
      programTitle: program.title
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.programs.delete(deleteDialog.programId);
      fetchPrograms(); // Refresh the list
      setDeleteDialog({ isOpen: false, programId: null, programTitle: '' });
    } catch (err) {
      alert('Error al eliminar el programa');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, programId: null, programTitle: '' });
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

  const formatTimeRange = (startTime, endTime) => {
    return `${startTime} - ${endTime}`;
  };

  const formatDays = (days) => {
    if (!days || days.length === 0) return 'Sin días asignados';
    if (days.length === 7) return 'Todos los días';
    return days.join(', ');
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
        <h2 style={{ color: '#2563eb', margin: 0 }}>Lista de Programas</h2>
        <button
          onClick={onCreate}
          style={{
            backgroundColor: '#2563eb',
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
          Nuevo Programa
        </button>
      </div>

      {/* Filters */}
      <div style={{
        backgroundColor: '#374151',
        borderRadius: '8px',
        padding: '1rem',
        marginBottom: '1rem',
        display: 'flex',
        gap: '1rem',
        flexWrap: 'wrap',
        alignItems: 'center'
      }}>
        <input
          type="text"
          placeholder="Buscar programas..."
          value={filters.search}
          onChange={(e) => handleFilterChange('search', e.target.value)}
          style={{
            backgroundColor: '#1f2937',
            border: '1px solid #4b5563',
            borderRadius: '6px',
            padding: '0.5rem',
            color: '#e5e7eb',
            minWidth: '200px'
          }}
        />
        
        <select
          value={filters.day}
          onChange={(e) => handleFilterChange('day', e.target.value)}
          style={{
            backgroundColor: '#1f2937',
            border: '1px solid #4b5563',
            borderRadius: '6px',
            padding: '0.5rem',
            color: '#e5e7eb'
          }}
        >
          <option value="">Todos los días</option>
          {daysOfWeek.map(day => (
            <option key={day} value={day}>{day}</option>
          ))}
        </select>

        <select
          value={filters.featured}
          onChange={(e) => handleFilterChange('featured', e.target.value)}
          style={{
            backgroundColor: '#1f2937',
            border: '1px solid #4b5563',
            borderRadius: '6px',
            padding: '0.5rem',
            color: '#e5e7eb'
          }}
        >
          <option value="">Todos los programas</option>
          <option value="true">Destacados</option>
          <option value="false">No destacados</option>
        </select>

        <button
          onClick={() => setFilters({
            search: '',
            day: '',
            featured: '',
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
          Limpiar Filtros
        </button>
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
          <p>Cargando programas...</p>
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

      {/* Programs List */}
      {!loading && !error && (
        <>
          <div style={{
            backgroundColor: '#1f2937',
            borderRadius: '8px',
            overflow: 'hidden'
          }}>
            {programs.length === 0 ? (
              <div style={{ 
                textAlign: 'center', 
                color: '#94a3b8', 
                padding: '3rem' 
              }}>
                <i className="fas fa-broadcast-tower" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
                <p>No se encontraron programas</p>
                <button
                  onClick={onCreate}
                  style={{
                    backgroundColor: '#2563eb',
                    color: 'white',
                    border: 'none',
                    borderRadius: '6px',
                    padding: '0.5rem 1rem',
                    cursor: 'pointer',
                    marginTop: '1rem'
                  }}
                >
                  Crear primer programa
                </button>
              </div>
            ) : (
              <div style={{ overflowX: 'auto' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                  <thead>
                    <tr style={{ backgroundColor: '#374151' }}>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Programa
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Conductor
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Horario
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Días
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
                    {programs.map((program, index) => (
                      <tr 
                        key={program.id}
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
                              {truncateText(program.title, 40)}
                              {program.is_featured && (
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
                            </div>
                            {program.description && (
                              <div style={{ 
                                color: '#9ca3af', 
                                fontSize: '0.8rem' 
                              }}>
                                {truncateText(program.description, 60)}
                              </div>
                            )}
                          </div>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db' }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <i className="fas fa-microphone" style={{ color: '#2563eb', fontSize: '0.9rem' }}></i>
                            {program.host}
                          </div>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db', fontSize: '0.9rem' }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <i className="fas fa-clock" style={{ color: '#16a34a', fontSize: '0.8rem' }}></i>
                            {formatTimeRange(program.start_time, program.end_time)}
                          </div>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db', fontSize: '0.8rem' }}>
                          {formatDays(program.days_of_week)}
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <span style={{
                            backgroundColor: program.is_featured ? '#16a34a' : '#6b7280',
                            color: 'white',
                            padding: '0.25rem 0.5rem',
                            borderRadius: '4px',
                            fontSize: '0.75rem',
                            fontWeight: '600'
                          }}>
                            {program.is_featured ? 'Destacado' : 'Normal'}
                          </span>
                        </td>
                        <td style={{ padding: '1rem', textAlign: 'center' }}>
                          <div style={{ display: 'flex', gap: '0.5rem', justifyContent: 'center' }}>
                            <button
                              onClick={() => onEdit(program)}
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
                              onClick={() => onManagePodcasts && onManagePodcasts(program)}
                              style={{
                                backgroundColor: '#16a34a',
                                color: 'white',
                                border: 'none',
                                borderRadius: '4px',
                                padding: '0.5rem',
                                cursor: 'pointer',
                                fontSize: '0.8rem'
                              }}
                              title="Gestionar Podcasts"
                            >
                              <i className="fas fa-podcast"></i>
                            </button>
                            <button
                              onClick={() => handleDeleteClick(program)}
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
        title="Eliminar Programa"
        message={`¿Estás seguro de que quieres eliminar el programa "${deleteDialog.programTitle}"? Esta acción no se puede deshacer.`}
        confirmText="Eliminar"
        cancelText="Cancelar"
        type="danger"
      />
    </div>
  );
}