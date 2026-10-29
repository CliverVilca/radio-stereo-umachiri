import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, getStatusColor, getStatusLabel, truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';
import ResponsiveTable from '../../components/ResponsiveTable';

export default function NewsList({ onEdit, onCreate }) {
  const [news, setNews] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    status: '',
    type: '',
    page: 1,
    per_page: 10
  });
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, newsId: null, newsTitle: '' });

  const fetchNews = async () => {
    try {
      setLoading(true);
      const response = await api.news.getAll(filters);
      setNews(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar las noticias');
      console.error('News fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchNews();
  }, [filters]);

  const handleDeleteClick = (news) => {
    setDeleteDialog({
      isOpen: true,
      newsId: news.id,
      newsTitle: news.title
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.news.delete(deleteDialog.newsId);
      fetchNews(); // Refresh the list
      setDeleteDialog({ isOpen: false, newsId: null, newsTitle: '' });
    } catch (err) {
      alert('Error al eliminar la noticia');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, newsId: null, newsTitle: '' });
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

  return (
    <div>
      {/* Header */}
      <div style={{ 
        display: 'flex', 
        justifyContent: 'space-between', 
        alignItems: 'center', 
        marginBottom: '2rem' 
      }}>
        <h2 style={{ color: '#ef4444', margin: 0 }}>Lista de Noticias</h2>
        <button
          onClick={onCreate}
          style={{
            backgroundColor: '#ef4444',
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
          Nueva Noticia
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
          placeholder="Buscar noticias..."
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
          value={filters.status}
          onChange={(e) => handleFilterChange('status', e.target.value)}
          style={{
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

        <select
          value={filters.type}
          onChange={(e) => handleFilterChange('type', e.target.value)}
          style={{
            backgroundColor: '#1f2937',
            border: '1px solid #4b5563',
            borderRadius: '6px',
            padding: '0.5rem',
            color: '#e5e7eb'
          }}
        >
          <option value="">Todos los tipos</option>
          <option value="local">Local</option>
          <option value="internacional">Internacional</option>
        </select>

        <button
          onClick={() => setFilters({
            search: '',
            status: '',
            type: '',
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
          <p>Cargando noticias...</p>
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

      {/* News List */}
      {!loading && !error && (
        <>
          <ResponsiveTable
            data={news}
            loading={loading}
            emptyMessage="No se encontraron noticias"
            emptyIcon="far fa-newspaper"
            onEdit={onEdit}
            onDelete={handleDeleteClick}
            columns={[
              {
                key: 'image',
                label: 'Imagen',
                render: (item) => {
                  const imageUrl = item.image ? `/storage/${item.image}` : null;
                  
                  return (
                    <div style={{ width: '80px', height: '60px' }}>
                      {item.image ? (
                        <img 
                          src={imageUrl} 
                          alt={item.title}
                          style={{ 
                            width: '100%', 
                            height: '100%', 
                            objectFit: 'cover', 
                            borderRadius: '6px',
                            border: '2px solid #374151'
                          }}
                          onError={(e) => {
                            e.target.style.display = 'none';
                            e.target.nextSibling.style.display = 'flex';
                          }}
                        />
                      ) : null}
                      <div 
                        style={{ 
                          display: item.image ? 'none' : 'flex', 
                          alignItems: 'center', 
                          justifyContent: 'center',
                          width: '100%',
                          height: '100%',
                          color: '#6b7280',
                          fontSize: '0.7rem',
                          border: '2px dashed #4b5563',
                          borderRadius: '6px',
                          backgroundColor: '#374151'
                        }}>
                        {item.image ? 'Error cargando' : <><i className="far fa-image"></i> Sin imagen</>}
                      </div>
                    </div>
                  );
                }
              },
              {
                key: 'title',
                label: 'Título',
                render: (item) => (
                  <div>
                    <div style={{ 
                      color: '#e5e7eb', 
                      fontWeight: '600', 
                      marginBottom: '0.25rem' 
                    }}>
                      {truncateText(item.title, 50)}
                    </div>
                    <div style={{ 
                      color: '#9ca3af', 
                      fontSize: '0.8rem' 
                    }}>
                      {truncateText(item.content, 80)}
                    </div>
                  </div>
                )
              },
              {
                key: 'author',
                label: 'Autor'
              },
              {
                key: 'type',
                label: 'Tipo',
                render: (item) => (
                  <span style={{
                    backgroundColor: item.type === 'local' ? '#2563eb' : '#16a34a',
                    color: 'white',
                    padding: '0.25rem 0.5rem',
                    borderRadius: '4px',
                    fontSize: '0.75rem',
                    fontWeight: '600'
                  }}>
                    {item.type === 'local' ? 'Local' : 'Internacional'}
                  </span>
                )
              },
              {
                key: 'status',
                label: 'Estado',
                render: (item) => (
                  <span style={{
                    backgroundColor: getStatusColor(item.status),
                    color: 'white',
                    padding: '0.25rem 0.5rem',
                    borderRadius: '4px',
                    fontSize: '0.75rem',
                    fontWeight: '600'
                  }}>
                    {getStatusLabel(item.status)}
                  </span>
                )
              },
              {
                key: 'published_at',
                label: 'Fecha',
                render: (item) => (
                  <span style={{ fontSize: '0.8rem' }}>
                    {formatDate(item.published_at)}
                  </span>
                )
              }
            ]}
          />

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
        title="Eliminar Noticia"
        message={`¿Estás seguro de que quieres eliminar la noticia "${deleteDialog.newsTitle}"? Esta acción no se puede deshacer.`}
        confirmText="Eliminar"
        cancelText="Cancelar"
        type="danger"
      />
    </div>
  );
}