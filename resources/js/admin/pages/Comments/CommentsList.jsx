import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, getStatusColor, getStatusLabel, truncateText } from '../../utils/helpers';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function CommentsList({ onNotification }) {
  const [comments, setComments] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [pagination, setPagination] = useState(null);
  const [filters, setFilters] = useState({
    search: '',
    status: '',
    news_id: '',
    page: 1,
    per_page: 10
  });
  const [selectedComments, setSelectedComments] = useState([]);
  const [actionDialog, setActionDialog] = useState({ 
    isOpen: false, 
    type: '', 
    commentId: null, 
    commentAuthor: '' 
  });
  const [bulkActionDialog, setBulkActionDialog] = useState({ 
    isOpen: false, 
    action: '', 
    count: 0 
  });

  const fetchComments = async () => {
    try {
      setLoading(true);
      const response = await api.comments.getAll(filters);
      setComments(response.data.items);
      setPagination(response.data.pagination);
      setError(null);
    } catch (err) {
      setError('Error al cargar los comentarios');
      console.error('Comments fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchComments();
  }, [filters]);

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

  const handleSelectComment = (commentId) => {
    setSelectedComments(prev => 
      prev.includes(commentId)
        ? prev.filter(id => id !== commentId)
        : [...prev, commentId]
    );
  };

  const handleSelectAll = () => {
    if (selectedComments.length === comments.length) {
      setSelectedComments([]);
    } else {
      setSelectedComments(comments.map(comment => comment.id));
    }
  };

  // Individual actions
  const handleApproveClick = (comment) => {
    setActionDialog({
      isOpen: true,
      type: 'approve',
      commentId: comment.id,
      commentAuthor: comment.author_name
    });
  };

  const handleRejectClick = (comment) => {
    setActionDialog({
      isOpen: true,
      type: 'reject',
      commentId: comment.id,
      commentAuthor: comment.author_name
    });
  };

  const handleDeleteClick = (comment) => {
    setActionDialog({
      isOpen: true,
      type: 'delete',
      commentId: comment.id,
      commentAuthor: comment.author_name
    });
  };

  const handleActionConfirm = async () => {
    try {
      const { type, commentId } = actionDialog;
      
      switch (type) {
        case 'approve':
          await api.comments.approve(commentId);
          onNotification('Comentario aprobado correctamente', 'success');
          break;
        case 'reject':
          await api.comments.reject(commentId);
          onNotification('Comentario rechazado correctamente', 'warning');
          break;
        case 'delete':
          await api.comments.delete(commentId);
          onNotification('Comentario eliminado correctamente', 'success');
          break;
      }
      
      fetchComments(); // Refresh the list
      setActionDialog({ isOpen: false, type: '', commentId: null, commentAuthor: '' });
    } catch (err) {
      onNotification('Error al procesar la acción', 'error');
      console.error('Action error:', err);
    }
  };

  const handleActionCancel = () => {
    setActionDialog({ isOpen: false, type: '', commentId: null, commentAuthor: '' });
  };

  // Bulk actions
  const handleBulkAction = (action) => {
    if (selectedComments.length === 0) {
      onNotification('Selecciona al menos un comentario', 'warning');
      return;
    }

    setBulkActionDialog({
      isOpen: true,
      action,
      count: selectedComments.length
    });
  };

  const handleBulkActionConfirm = async () => {
    try {
      const { action } = bulkActionDialog;
      
      switch (action) {
        case 'approve':
          await api.comments.bulkApprove(selectedComments);
          onNotification(`${selectedComments.length} comentarios aprobados correctamente`, 'success');
          break;
        case 'reject':
          await api.comments.bulkReject(selectedComments);
          onNotification(`${selectedComments.length} comentarios rechazados correctamente`, 'warning');
          break;
        case 'delete':
          await api.comments.bulkDelete(selectedComments);
          onNotification(`${selectedComments.length} comentarios eliminados correctamente`, 'success');
          break;
      }
      
      setSelectedComments([]);
      fetchComments(); // Refresh the list
      setBulkActionDialog({ isOpen: false, action: '', count: 0 });
    } catch (err) {
      onNotification('Error al procesar la acción masiva', 'error');
      console.error('Bulk action error:', err);
    }
  };

  const handleBulkActionCancel = () => {
    setBulkActionDialog({ isOpen: false, action: '', count: 0 });
  };

  const getActionDialogConfig = () => {
    const { type, commentAuthor } = actionDialog;
    
    const configs = {
      approve: {
        title: 'Aprobar Comentario',
        message: `¿Estás seguro de que quieres aprobar el comentario de "${commentAuthor}"?`,
        confirmText: 'Aprobar',
        type: 'info'
      },
      reject: {
        title: 'Rechazar Comentario',
        message: `¿Estás seguro de que quieres rechazar el comentario de "${commentAuthor}"?`,
        confirmText: 'Rechazar',
        type: 'warning'
      },
      delete: {
        title: 'Eliminar Comentario',
        message: `¿Estás seguro de que quieres eliminar permanentemente el comentario de "${commentAuthor}"? Esta acción no se puede deshacer.`,
        confirmText: 'Eliminar',
        type: 'danger'
      }
    };
    
    return configs[type] || {};
  };

  const getBulkActionDialogConfig = () => {
    const { action, count } = bulkActionDialog;
    
    const configs = {
      approve: {
        title: 'Aprobar Comentarios',
        message: `¿Estás seguro de que quieres aprobar ${count} comentarios seleccionados?`,
        confirmText: 'Aprobar Todos',
        type: 'info'
      },
      reject: {
        title: 'Rechazar Comentarios',
        message: `¿Estás seguro de que quieres rechazar ${count} comentarios seleccionados?`,
        confirmText: 'Rechazar Todos',
        type: 'warning'
      },
      delete: {
        title: 'Eliminar Comentarios',
        message: `¿Estás seguro de que quieres eliminar permanentemente ${count} comentarios seleccionados? Esta acción no se puede deshacer.`,
        confirmText: 'Eliminar Todos',
        type: 'danger'
      }
    };
    
    return configs[action] || {};
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
        <h2 style={{ color: '#16a34a', margin: 0 }}>Moderación de Comentarios</h2>
        
        {/* Bulk Actions */}
        {selectedComments.length > 0 && (
          <div style={{ display: 'flex', gap: '0.5rem' }}>
            <button
              onClick={() => handleBulkAction('approve')}
              style={{
                backgroundColor: '#16a34a',
                color: 'white',
                border: 'none',
                borderRadius: '6px',
                padding: '0.5rem 1rem',
                cursor: 'pointer',
                fontSize: '0.8rem',
                fontWeight: '600'
              }}
            >
              <i className="fas fa-check" style={{ marginRight: '0.5rem' }}></i>
              Aprobar ({selectedComments.length})
            </button>
            <button
              onClick={() => handleBulkAction('reject')}
              style={{
                backgroundColor: '#f59e0b',
                color: 'white',
                border: 'none',
                borderRadius: '6px',
                padding: '0.5rem 1rem',
                cursor: 'pointer',
                fontSize: '0.8rem',
                fontWeight: '600'
              }}
            >
              <i className="fas fa-times" style={{ marginRight: '0.5rem' }}></i>
              Rechazar ({selectedComments.length})
            </button>
            <button
              onClick={() => handleBulkAction('delete')}
              style={{
                backgroundColor: '#ef4444',
                color: 'white',
                border: 'none',
                borderRadius: '6px',
                padding: '0.5rem 1rem',
                cursor: 'pointer',
                fontSize: '0.8rem',
                fontWeight: '600'
              }}
            >
              <i className="fas fa-trash" style={{ marginRight: '0.5rem' }}></i>
              Eliminar ({selectedComments.length})
            </button>
          </div>
        )}
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
          placeholder="Buscar comentarios..."
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
          <option value="pending">Pendientes</option>
          <option value="approved">Aprobados</option>
          <option value="rejected">Rechazados</option>
        </select>

        <button
          onClick={() => setFilters({
            search: '',
            status: '',
            news_id: '',
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
          <p>Cargando comentarios...</p>
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

      {/* Comments List */}
      {!loading && !error && (
        <>
          <div style={{
            backgroundColor: '#1f2937',
            borderRadius: '8px',
            overflow: 'hidden'
          }}>
            {comments.length === 0 ? (
              <div style={{ 
                textAlign: 'center', 
                color: '#94a3b8', 
                padding: '3rem' 
              }}>
                <i className="fas fa-comments" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
                <p>No se encontraron comentarios</p>
              </div>
            ) : (
              <div style={{ overflowX: 'auto' }}>
                <table style={{ width: '100%', borderCollapse: 'collapse' }}>
                  <thead>
                    <tr style={{ backgroundColor: '#374151' }}>
                      <th style={{ padding: '1rem', textAlign: 'center', color: '#e5e7eb', fontWeight: '600', width: '50px' }}>
                        <input
                          type="checkbox"
                          checked={selectedComments.length === comments.length && comments.length > 0}
                          onChange={handleSelectAll}
                          style={{ accentColor: '#16a34a' }}
                        />
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Comentario
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Autor
                      </th>
                      <th style={{ padding: '1rem', textAlign: 'left', color: '#e5e7eb', fontWeight: '600' }}>
                        Noticia
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
                    {comments.map((comment, index) => (
                      <tr 
                        key={comment.id}
                        style={{ 
                          borderBottom: '1px solid #374151',
                          backgroundColor: index % 2 === 0 ? '#1f2937' : '#111827'
                        }}
                      >
                        <td style={{ padding: '1rem', textAlign: 'center' }}>
                          <input
                            type="checkbox"
                            checked={selectedComments.includes(comment.id)}
                            onChange={() => handleSelectComment(comment.id)}
                            style={{ accentColor: '#16a34a' }}
                          />
                        </td>
                        <td style={{ padding: '1rem', maxWidth: '300px' }}>
                          <div style={{ 
                            color: '#e5e7eb', 
                            marginBottom: '0.25rem',
                            lineHeight: '1.4'
                          }}>
                            {truncateText(comment.content, 120)}
                          </div>
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <div>
                            <div style={{ color: '#d1d5db', fontWeight: '600' }}>
                              {comment.author_name}
                            </div>
                            <div style={{ color: '#9ca3af', fontSize: '0.8rem' }}>
                              {comment.author_email}
                            </div>
                          </div>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db', fontSize: '0.9rem' }}>
                          {comment.news ? truncateText(comment.news.title, 40) : 'Noticia eliminada'}
                        </td>
                        <td style={{ padding: '1rem' }}>
                          <span style={{
                            backgroundColor: getStatusColor(comment.status),
                            color: 'white',
                            padding: '0.25rem 0.5rem',
                            borderRadius: '4px',
                            fontSize: '0.75rem',
                            fontWeight: '600'
                          }}>
                            {getStatusLabel(comment.status)}
                          </span>
                        </td>
                        <td style={{ padding: '1rem', color: '#d1d5db', fontSize: '0.8rem' }}>
                          {formatDate(comment.created_at)}
                        </td>
                        <td style={{ padding: '1rem', textAlign: 'center' }}>
                          <div style={{ display: 'flex', gap: '0.25rem', justifyContent: 'center' }}>
                            {comment.status === 'pending' && (
                              <>
                                <button
                                  onClick={() => handleApproveClick(comment)}
                                  style={{
                                    backgroundColor: '#16a34a',
                                    color: 'white',
                                    border: 'none',
                                    borderRadius: '4px',
                                    padding: '0.4rem',
                                    cursor: 'pointer',
                                    fontSize: '0.7rem'
                                  }}
                                  title="Aprobar"
                                >
                                  <i className="fas fa-check"></i>
                                </button>
                                <button
                                  onClick={() => handleRejectClick(comment)}
                                  style={{
                                    backgroundColor: '#f59e0b',
                                    color: 'white',
                                    border: 'none',
                                    borderRadius: '4px',
                                    padding: '0.4rem',
                                    cursor: 'pointer',
                                    fontSize: '0.7rem'
                                  }}
                                  title="Rechazar"
                                >
                                  <i className="fas fa-times"></i>
                                </button>
                              </>
                            )}
                            <button
                              onClick={() => handleDeleteClick(comment)}
                              style={{
                                backgroundColor: '#ef4444',
                                color: 'white',
                                border: 'none',
                                borderRadius: '4px',
                                padding: '0.4rem',
                                cursor: 'pointer',
                                fontSize: '0.7rem'
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

      {/* Individual Action Confirmation Dialog */}
      <ConfirmDialog
        isOpen={actionDialog.isOpen}
        onClose={handleActionCancel}
        onConfirm={handleActionConfirm}
        {...getActionDialogConfig()}
      />

      {/* Bulk Action Confirmation Dialog */}
      <ConfirmDialog
        isOpen={bulkActionDialog.isOpen}
        onClose={handleBulkActionCancel}
        onConfirm={handleBulkActionConfirm}
        {...getBulkActionDialogConfig()}
      />
    </div>
  );
}