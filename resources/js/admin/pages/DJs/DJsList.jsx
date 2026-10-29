import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function DJsList({ onEdit, onCreate }) {
  const [djs, setDJs] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    status: '',
    is_featured: '',
    page: 1,
    per_page: 10
  });
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, djId: null, djName: '' });

  const fetchDJs = async () => {
    try {
      setLoading(true);
      const response = await api.djs.getAll(filters);
      setDJs(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar los DJs');
      console.error('DJs fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchDJs();
  }, [filters]);

  const handleDeleteClick = (dj) => {
    setDeleteDialog({
      isOpen: true,
      djId: dj.id,
      djName: dj.name
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.djs.delete(deleteDialog.djId);
      fetchDJs(); // Refresh the list
      setDeleteDialog({ isOpen: false, djId: null, djName: '' });
    } catch (err) {
      alert('Error al eliminar el DJ');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, djId: null, djName: '' });
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

  const getStatusColor = (status) => {
    return status === 'active' ? '#16a34a' : '#6b7280';
  };

  const getStatusLabel = (status) => {
    return status === 'active' ? 'Activo' : 'Inactivo';
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
        <h2 style={{ color: '#8b5cf6', margin: 0 }}>Gestión de DJs</h2>
        <button
          onClick={onCreate}
          style={{
            backgroundColor: '#8b5cf6',
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
          Nuevo DJ
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
            Buscar DJs
          </label>
          <input
            type="text"
            placeholder="Buscar por nombre o especialidad..."
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
            Estado
          </label>
          <select
            value={filters.status}
            onChange={(e) => handleFilterChange('status', e.target.value)}
            style={{
              width: '100%',
              backgroundColor: '#1f2937',
              border: '1px solid #4b5563',
              borderRadius: '6px',
              padding: '0.5rem',
              color: '#e5e7eb'
            }}
          >
            <option value="">Todos los estados</option>
            <option value="active">Activos</option>
            <option value="inactive">Inactivos</option>
          </select>
        </div>

        <div>
          <label style={{ 
            display: 'block', 
            color: '#e5e7eb', 
            fontSize: '0.8rem', 
            marginBottom: '0.25rem' 
          }}>
            Destacado
          </label>
          <select
            value={filters.is_featured}
            onChange={(e) => handleFilterChange('is_featured', e.target.value)}
            style={{
              width: '100%',
              backgroundColor: '#1f2937',
              border: '1px solid #4b5563',
              borderRadius: '6px',
              padding: '0.5rem',
              color: '#e5e7eb'
            }}
          >
            <option value="">Todos</option>
            <option value="true">Destacados</option>
            <option value="false">No destacados</option>
          </select>
        </div>

        <div>
          <button
            onClick={() => setFilters({
              search: '',
              status: '',
              is_featured: '',
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
              fontSize: '0.8rem',
              width: '100%'
            }}
          >
            Limpiar Filtros
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
          <p>Cargando DJs...</p>
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

      {/* DJs Grid */}
      {!loading && !error && (
        <>
          {djs.length === 0 ? (
            <div style={{ 
              textAlign: 'center', 
              color: '#94a3b8', 
              padding: '3rem',
              backgroundColor: '#1f2937',
              borderRadius: '8px'
            }}>
              <i className="fas fa-microphone" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
              <p>No se encontraron DJs</p>
              <button
                onClick={onCreate}
                style={{
                  backgroundColor: '#8b5cf6',
                  color: 'white',
                  border: 'none',
                  borderRadius: '6px',
                  padding: '0.5rem 1rem',
                  cursor: 'pointer',
                  marginTop: '1rem'
                }}
              >
                Crear primer DJ
              </button>
            </div>
          ) : (
            <div style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(auto-fill, minmax(320px, 1fr))',
              gap: '1.5rem'
            }}>
              {djs.map((dj) => (
                <div 
                  key={dj.id}
                  style={{
                    backgroundColor: '#1f2937',
                    borderRadius: '12px',
                    overflow: 'hidden',
                    boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
                    transition: 'transform 0.2s ease, box-shadow 0.2s ease'
                  }}
                  onMouseEnter={(e) => {
                    e.currentTarget.style.transform = 'translateY(-4px)';
                    e.currentTarget.style.boxShadow = '0 8px 25px rgba(0,0,0,0.8)';
                  }}
                  onMouseLeave={(e) => {
                    e.currentTarget.style.transform = 'translateY(0)';
                    e.currentTarget.style.boxShadow = '0 4px 12px rgba(0,0,0,0.7)';
                  }}
                >
                  {/* Photo */}
                  <div style={{
                    height: '200px',
                    backgroundColor: '#374151',
                    position: 'relative',
                    overflow: 'hidden'
                  }}>
                    {dj.photo ? (
                      <img 
                        src={`/storage/${dj.photo}`}
                        alt={dj.name}
                        style={{
                          width: '100%',
                          height: '100%',
                          objectFit: 'cover'
                        }}
                        onError={(e) => {
                          e.target.style.display = 'none';
                          e.target.nextSibling.style.display = 'flex';
                        }}
                      />
                    ) : null}
                    
                    {/* Fallback when no photo */}
                    <div style={{
                      display: dj.photo ? 'none' : 'flex',
                      alignItems: 'center',
                      justifyContent: 'center',
                      height: '100%',
                      color: '#9ca3af'
                    }}>
                      <div style={{ textAlign: 'center' }}>
                        <i className="fas fa-microphone" style={{ fontSize: '3rem', marginBottom: '0.5rem' }}></i>
                        <p style={{ margin: 0, fontSize: '0.9rem' }}>Sin foto</p>
                      </div>
                    </div>

                    {/* Status Badge */}
                    <div style={{
                      position: 'absolute',
                      top: '0.5rem',
                      left: '0.5rem',
                      backgroundColor: getStatusColor(dj.status),
                      color: 'white',
                      padding: '0.25rem 0.5rem',
                      borderRadius: '4px',
                      fontSize: '0.75rem',
                      fontWeight: '600'
                    }}>
                      {getStatusLabel(dj.status)}
                    </div>

                    {/* Featured Badge */}
                    {dj.is_featured && (
                      <div style={{
                        position: 'absolute',
                        top: '0.5rem',
                        right: '0.5rem',
                        backgroundColor: '#f59e0b',
                        color: 'white',
                        padding: '0.25rem 0.5rem',
                        borderRadius: '4px',
                        fontSize: '0.75rem',
                        fontWeight: '600'
                      }}>
                        <i className="fas fa-star" style={{ marginRight: '0.25rem' }}></i>
                        Destacado
                      </div>
                    )}
                  </div>

                  {/* Content */}
                  <div style={{ padding: '1.5rem' }}>
                    <h3 style={{ 
                      color: '#e5e7eb', 
                      margin: '0 0 0.5rem 0',
                      fontSize: '1.2rem',
                      fontWeight: '600'
                    }}>
                      {dj.name}
                    </h3>
                    
                    {dj.specialties && (
                      <div style={{ 
                        color: '#8b5cf6', 
                        fontSize: '0.9rem',
                        fontWeight: '500',
                        marginBottom: '0.5rem'
                      }}>
                        <i className="fas fa-music" style={{ marginRight: '0.5rem' }}></i>
                        {dj.specialties}
                      </div>
                    )}

                    {dj.bio && (
                      <p style={{ 
                        color: '#9ca3af', 
                        margin: '0 0 1rem 0',
                        fontSize: '0.9rem',
                        lineHeight: '1.4'
                      }}>
                        {truncateText(dj.bio, 100)}
                      </p>
                    )}

                    {/* Contact Info */}
                    <div style={{ marginBottom: '1rem' }}>
                      {dj.email && (
                        <div style={{ 
                          color: '#6b7280', 
                          fontSize: '0.8rem',
                          marginBottom: '0.25rem',
                          display: 'flex',
                          alignItems: 'center',
                          gap: '0.5rem'
                        }}>
                          <i className="fas fa-envelope"></i>
                          {dj.email}
                        </div>
                      )}
                      {dj.phone && (
                        <div style={{ 
                          color: '#6b7280', 
                          fontSize: '0.8rem',
                          display: 'flex',
                          alignItems: 'center',
                          gap: '0.5rem'
                        }}>
                          <i className="fas fa-phone"></i>
                          {dj.phone}
                        </div>
                      )}
                    </div>

                    {/* Actions */}
                    <div style={{ 
                      display: 'flex', 
                      gap: '0.5rem',
                      justifyContent: 'flex-end'
                    }}>
                      <button
                        onClick={() => onEdit(dj)}
                        style={{
                          backgroundColor: '#2563eb',
                          color: 'white',
                          border: 'none',
                          borderRadius: '6px',
                          padding: '0.5rem 1rem',
                          cursor: 'pointer',
                          fontSize: '0.8rem',
                          fontWeight: '600',
                          display: 'flex',
                          alignItems: 'center',
                          gap: '0.5rem'
                        }}
                      >
                        <i className="fas fa-edit"></i>
                        Editar
                      </button>
                      <button
                        onClick={() => handleDeleteClick(dj)}
                        style={{
                          backgroundColor: '#ef4444',
                          color: 'white',
                          border: 'none',
                          borderRadius: '6px',
                          padding: '0.5rem 1rem',
                          cursor: 'pointer',
                          fontSize: '0.8rem',
                          fontWeight: '600',
                          display: 'flex',
                          alignItems: 'center',
                          gap: '0.5rem'
                        }}
                      >
                        <i className="fas fa-trash"></i>
                        Eliminar
                      </button>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          )}

          {/* Pagination */}
          {pagination && pagination.last_page > 1 && (
            <div style={{
              display: 'flex',
              justifyContent: 'space-between',
              alignItems: 'center',
              marginTop: '2rem',
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
        title="Eliminar DJ"
        message={`¿Estás seguro de que quieres eliminar al DJ "${deleteDialog.djName}"? Esta acción no se puede deshacer.`}
        confirmText="Eliminar"
        cancelText="Cancelar"
        type="danger"
      />
    </div>
  );
}