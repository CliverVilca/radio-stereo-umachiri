import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function GalleriesList({ onEdit, onCreate }) {
  const [galleries, setGalleries] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    page: 1,
    per_page: 10
  });
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, galleryId: null, galleryTitle: '' });

  const fetchGalleries = async () => {
    try {
      setLoading(true);
      const response = await api.galleries.getAll(filters);
      setGalleries(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar las galerías');
      console.error('Galleries fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchGalleries();
  }, [filters]);

  const handleDeleteClick = (gallery) => {
    setDeleteDialog({
      isOpen: true,
      galleryId: gallery.id,
      galleryTitle: gallery.title
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.galleries.delete(deleteDialog.galleryId);
      fetchGalleries(); // Refresh the list
      setDeleteDialog({ isOpen: false, galleryId: null, galleryTitle: '' });
    } catch (err) {
      alert('Error al eliminar la galería');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, galleryId: null, galleryTitle: '' });
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

  const getImageCount = (images) => {
    if (!images || !Array.isArray(images)) return 0;
    return images.length;
  };

  const getFirstImage = (images) => {
    if (!images || !Array.isArray(images) || images.length === 0) return null;
    return `/storage/${images[0]}`;
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
        <h2 style={{ color: '#f59e0b', margin: 0 }}>Lista de Galerías</h2>
        <button
          onClick={onCreate}
          style={{
            backgroundColor: '#f59e0b',
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
          Nueva Galería
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
        alignItems: 'center'
      }}>
        <input
          type="text"
          placeholder="Buscar galerías..."
          value={filters.search}
          onChange={(e) => handleFilterChange('search', e.target.value)}
          style={{
            backgroundColor: '#1f2937',
            border: '1px solid #4b5563',
            borderRadius: '6px',
            padding: '0.5rem',
            color: '#e5e7eb',
            minWidth: '300px'
          }}
        />
        
        <button
          onClick={() => setFilters({
            search: '',
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
          <p>Cargando galerías...</p>
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

      {/* Galleries Grid */}
      {!loading && !error && (
        <>
          {galleries.length === 0 ? (
            <div style={{ 
              textAlign: 'center', 
              color: '#94a3b8', 
              padding: '3rem',
              backgroundColor: '#1f2937',
              borderRadius: '8px'
            }}>
              <i className="fas fa-images" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
              <p>No se encontraron galerías</p>
              <button
                onClick={onCreate}
                style={{
                  backgroundColor: '#f59e0b',
                  color: 'white',
                  border: 'none',
                  borderRadius: '6px',
                  padding: '0.5rem 1rem',
                  cursor: 'pointer',
                  marginTop: '1rem'
                }}
              >
                Crear primera galería
              </button>
            </div>
          ) : (
            <div style={{
              display: 'grid',
              gridTemplateColumns: 'repeat(auto-fill, minmax(300px, 1fr))',
              gap: '1.5rem'
            }}>
              {galleries.map((gallery) => (
                <div 
                  key={gallery.id}
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
                  {/* Image Preview */}
                  <div style={{
                    height: '200px',
                    backgroundColor: '#374151',
                    position: 'relative',
                    overflow: 'hidden'
                  }}>
                    {getFirstImage(gallery.images) ? (
                      <img 
                        src={getFirstImage(gallery.images)}
                        alt={gallery.title}
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
                    
                    {/* Fallback when no image */}
                    <div style={{
                      display: getFirstImage(gallery.images) ? 'none' : 'flex',
                      alignItems: 'center',
                      justifyContent: 'center',
                      height: '100%',
                      color: '#9ca3af'
                    }}>
                      <div style={{ textAlign: 'center' }}>
                        <i className="fas fa-images" style={{ fontSize: '3rem', marginBottom: '0.5rem' }}></i>
                        <p style={{ margin: 0, fontSize: '0.9rem' }}>Sin imágenes</p>
                      </div>
                    </div>

                    {/* Image Count Badge */}
                    <div style={{
                      position: 'absolute',
                      top: '0.5rem',
                      right: '0.5rem',
                      backgroundColor: 'rgba(0, 0, 0, 0.8)',
                      color: 'white',
                      padding: '0.25rem 0.5rem',
                      borderRadius: '4px',
                      fontSize: '0.8rem',
                      fontWeight: '600'
                    }}>
                      <i className="fas fa-image" style={{ marginRight: '0.25rem' }}></i>
                      {getImageCount(gallery.images)}
                    </div>
                  </div>

                  {/* Content */}
                  <div style={{ padding: '1.5rem' }}>
                    <h3 style={{ 
                      color: '#e5e7eb', 
                      margin: '0 0 0.5rem 0',
                      fontSize: '1.1rem',
                      fontWeight: '600'
                    }}>
                      {truncateText(gallery.title, 40)}
                    </h3>
                    
                    {gallery.description && (
                      <p style={{ 
                        color: '#9ca3af', 
                        margin: '0 0 1rem 0',
                        fontSize: '0.9rem',
                        lineHeight: '1.4'
                      }}>
                        {truncateText(gallery.description, 80)}
                      </p>
                    )}

                    <div style={{ 
                      display: 'flex', 
                      alignItems: 'center', 
                      justifyContent: 'space-between',
                      marginBottom: '1rem'
                    }}>
                      <div style={{ 
                        color: '#6b7280', 
                        fontSize: '0.8rem',
                        display: 'flex',
                        alignItems: 'center',
                        gap: '0.5rem'
                      }}>
                        <i className="fas fa-calendar"></i>
                        {formatDate(gallery.created_at)}
                      </div>
                    </div>

                    {/* Actions */}
                    <div style={{ 
                      display: 'flex', 
                      gap: '0.5rem',
                      justifyContent: 'flex-end'
                    }}>
                      <button
                        onClick={() => onEdit(gallery)}
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
                        onClick={() => handleDeleteClick(gallery)}
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
        title="Eliminar Galería"
        message={`¿Estás seguro de que quieres eliminar la galería "${deleteDialog.galleryTitle}"? Todas las imágenes asociadas también se eliminarán. Esta acción no se puede deshacer.`}
        confirmText="Eliminar"
        cancelText="Cancelar"
        type="danger"
      />
    </div>
  );
}