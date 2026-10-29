import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function SportsList({ onEdit, onCreate }) {
  const [sports, setSports] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    category: '',
    status: '',
    is_featured: '',
    page: 1,
    per_page: 10
  });
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, sportId: null, sportTitle: '' });

  const categories = [
    { value: 'futbol', label: 'Fútbol' },
    { value: 'basquet', label: 'Básquet' },
    { value: 'voleibol', label: 'Vóleibol' },
    { value: 'atletismo', label: 'Atletismo' },
    { value: 'otros', label: 'Otros' }
  ];

  const fetchSports = async () => {
    try {
      setLoading(true);
      const response = await api.sports.getAll(filters);
      setSports(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar las noticias deportivas');
      console.error('Sports fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchSports();
  }, [filters]);

  const handleDeleteClick = (sport) => {
    setDeleteDialog({
      isOpen: true,
      sportId: sport.id,
      sportTitle: sport.title
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.sports.delete(deleteDialog.sportId);
      fetchSports(); // Refresh the list
      setDeleteDialog({ isOpen: false, sportId: null, sportTitle: '' });
    } catch (err) {
      alert('Error al eliminar la noticia deportiva');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, sportId: null, sportTitle: '' });
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

  const getCategoryLabel = (category) => {
    const cat = categories.find(c => c.value === category);
    return cat ? cat.label : category;
  };

  const getStatusColor = (status) => {
    return status === 'published' ? '#16a34a' : '#f59e0b';
  };

  const getStatusLabel = (status) => {
    return status === 'published' ? 'Publicado' : 'Borrador';
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
        <h2 style={{ color: '#f97316', margin: 0 }}>Noticias Deportivas</h2>
        <button
          onClick={onCreate}
          style={{
            backgroundColor: '#f97316',
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
          Nueva Noticia Deportiva
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
            Buscar
          </label>
          <input
            type="text"
            placeholder="Buscar noticias deportivas..."
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
            Categoría
          </label>
          <select
            value={filters.category}
            onChange={(e) => handleFilterChange('category', e.target.value)}
            style={{
              width: '100%',
              backgroundColor: '#1f2937',
              border: '1px solid #4b5563',
              borderRadius: '6px',
              padding: '0.5rem',
              color: '#e5e7eb'
            }}
          >
            <option value="">Todas las categorías</option>
            {categories.map(category => (
              <option key={category.value} value={category.value}>{category.label}</option>
            ))}
          </select>
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
            <option value="published">Publicado</option>
            <option value="draft">Borrador</option>
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
              category: '',
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
          <p>Cargando noticias deportivas...</p>
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

      {/* Sports List */}
      {!loading && !error && (
        <>
          <div style={{
            backgroundColor: '#1f2937',
            borderRadius: '8px',
            overflow: 'hidden'
          }}>
            {sports.length === 0 ? (
              <div style={{ 
                textAlign: 'center', 
                color: '#94a3b8', 
                padding: '3rem' 
              }}>
                <i className="fas fa-futbol" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
                <p>No se encontraron noticias deportivas</p>
                <button
                  onClick={onCreate}
                  style={{
                    backgroundColor: '#f97316',
                    color: 'white',
                    border: 'none',
                    borderRadius: '6px',
                    padding: '0.5rem 1rem',
                    cursor: 'pointer',
                    marginTop: '1rem'
                  }}
                >
                  Crear primera noticia deportiva
                </button>
              </div>
            ) : (
              <div style={{ overflowX: 'auto' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                  <thead>
                    <tr style={{ backgroundColor: '#374151' }}>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Noticia
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Categoría
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Autor
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Estado
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Fecha
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'center', color: '#e5e7eb', fontWeight: '600' }}>
                        Acciones
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {sports.map((sport, index) => (
                      <tr 
                        key={sport.id}
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
                              {truncateText(sport.title, 50)}
                              {sport.is_featured && (
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
                            {sport.content && (
                              <div style={{ 
                                color: '#9ca3af', 
                                fontSize: '0.8rem' 
                              }}>
                                {truncateText(sport.content, 80)}
                              </div>
                            )}
                          </div>
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <span style={{
                            backgroundColor: '#f97316',
                            color: 'white',
                            padding: '0.25rem 0.5rem',
                            borderRadius: '4px',
                            fontSize: '0.75rem',
                            fontWeight: '600'
                          }}>
                            {getCategoryLabel(sport.category)}
                          </span>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db' }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <i className="fas fa-user" style={{ color: '#f97316', fontSize: '0.8rem' }}></i>
                            {sport.author}
                          </div>
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <span style={{
                            backgroundColor: getStatusColor(sport.status),
                            color: 'white',
                            padding: '0.25rem 0.5rem',
                            borderRadius: '4px',
                            fontSize: '0.75rem',
                            fontWeight: '600'
                          }}>
                            {getStatusLabel(sport.status)}
                          </span>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db', fontSize: '0.8rem' }}>
                          {formatDate(sport.published_at)}
                        </td>
                        <td style={{ padding: '1rem', textAlign: 'center' }}>
                          <div style={{ display: 'flex', gap: '0.5rem', justifyContent: 'center' }}>
                            <button
                              onClick={() => onEdit(sport)}
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
                              onClick={() => handleDeleteClick(sport)}
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
        title="Eliminar Noticia Deportiva"
        message={`¿Estás seguro de que quieres eliminar la noticia deportiva "${deleteDialog.sportTitle}"? Esta acción no se puede deshacer.`}
        confirmText="Eliminar"
        cancelText="Cancelar"
        type="danger"
      />
    </div>
  );
}