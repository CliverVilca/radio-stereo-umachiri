import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { formatDate, formatFileSize, truncateText, handleApiError } from '../../utils/helpers';
import Modal from '../../components/Modal';
import ConfirmDialog from '../../components/ConfirmDialog';

export default function PodcastManager({ program, onClose, onNotification }) {
  const [podcasts, setPodcasts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [editingPodcast, setEditingPodcast] = useState(null);
  const [deleteDialog, setDeleteDialog] = useState({ isOpen: false, podcastId: null, podcastTitle: '' });

  const fetchPodcasts = async () => {
    try {
      setLoading(true);
      const response = await api.programs.podcasts.getAll(program.id);
      setPodcasts(response.data.items || response.data);
      setError(null);
    } catch (err) {
      setError('Error al cargar los podcasts');
      console.error('Podcasts fetch error:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    if (program?.id) {
      fetchPodcasts();
    }
  }, [program]);

  const handleCreate = () => {
    setEditingPodcast(null);
    setShowForm(true);
  };

  const handleEdit = (podcast) => {
    setEditingPodcast(podcast);
    setShowForm(true);
  };

  const handleFormClose = () => {
    setShowForm(false);
    setEditingPodcast(null);
  };

  const handleFormSave = () => {
    setShowForm(false);
    setEditingPodcast(null);
    fetchPodcasts();
    onNotification('Podcast guardado correctamente', 'success');
  };

  const handleDeleteClick = (podcast) => {
    setDeleteDialog({
      isOpen: true,
      podcastId: podcast.id,
      podcastTitle: podcast.title
    });
  };

  const handleDeleteConfirm = async () => {
    try {
      await api.programs.podcasts.delete(program.id, deleteDialog.podcastId);
      fetchPodcasts();
      setDeleteDialog({ isOpen: false, podcastId: null, podcastTitle: '' });
      onNotification('Podcast eliminado correctamente', 'success');
    } catch (err) {
      onNotification('Error al eliminar el podcast', 'error');
      console.error('Delete error:', err);
    }
  };

  const handleDeleteCancel = () => {
    setDeleteDialog({ isOpen: false, podcastId: null, podcastTitle: '' });
  };

  return (
    <Modal
      isOpen={true}
      onClose={onClose}
      title={`Podcasts - ${program.title}`}
      size="xlarge"
    >
      <div>
        {/* Header */}
        <div style={{ 
          display: 'flex', 
          justifyContent: 'space-between', 
          alignItems: 'center', 
          marginBottom: '2rem' 
        }}>
          <div>
            <h3 style={{ color: '#e5e7eb', margin: 0, marginBottom: '0.5rem' }}>
              Gestión de Podcasts
            </h3>
            <p style={{ color: '#9ca3af', margin: 0, fontSize: '0.9rem' }}>
              Programa: {program.title} • Conductor: {program.host}
            </p>
          </div>
          <button
            onClick={handleCreate}
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
            Nuevo Podcast
          </button>
        </div>

        {/* Loading State */}
        {loading && (
          <div style={{ 
            textAlign: 'center', 
            color: '#94a3b8', 
            padding: '3rem'
          }}>
            <i className="fas fa-spinner fa-spin" style={{ fontSize: '2rem', marginBottom: '1rem' }}></i>
            <p>Cargando podcasts...</p>
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

        {/* Podcasts List */}
        {!loading && !error && (
          <div style={{
            backgroundColor: '#374151',
            borderRadius: '8px',
            overflow: 'hidden'
          }}>
            {podcasts.length === 0 ? (
              <div style={{ 
                textAlign: 'center', 
                color: '#94a3b8', 
                padding: '3rem' 
              }}>
                <i className="fas fa-podcast" style={{ fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }}></i>
                <p>No hay podcasts para este programa</p>
                <button
                  onClick={handleCreate}
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
                  Crear primer podcast
                </button>
              </div>
            ) : (
              <div style={{ display: 'grid', gap: '1rem', padding: '1rem' }}>
                {podcasts.map((podcast) => (
                  <div 
                    key={podcast.id}
                    style={{
                      backgroundColor: '#1f2937',
                      borderRadius: '8px',
                      padding: '1.5rem',
                      border: '1px solid #4b5563'
                    }}
                  >
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
                      <div style={{ flex: 1 }}>
                        <h4 style={{ 
                          color: '#e5e7eb', 
                          margin: '0 0 0.5rem 0',
                          fontSize: '1.1rem',
                          fontWeight: '600'
                        }}>
                          {podcast.title}
                        </h4>
                        
                        {podcast.description && (
                          <p style={{ 
                            color: '#9ca3af', 
                            margin: '0 0 1rem 0',
                            fontSize: '0.9rem',
                            lineHeight: '1.4'
                          }}>
                            {truncateText(podcast.description, 150)}
                          </p>
                        )}
                        
                        <div style={{ 
                          display: 'flex', 
                          gap: '1rem', 
                          flexWrap: 'wrap',
                          fontSize: '0.8rem',
                          color: '#6b7280'
                        }}>
                          <div style={{ display: 'flex', alignItems: 'center', gap: '0.25rem' }}>
                            <i className="fas fa-calendar"></i>
                            {formatDate(podcast.published_at)}
                          </div>
                          {podcast.duration && (
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.25rem' }}>
                              <i className="fas fa-clock"></i>
                              {podcast.duration}
                            </div>
                          )}
                          {podcast.audio_file && (
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.25rem' }}>
                              <i className="fas fa-file-audio"></i>
                              Audio disponible
                            </div>
                          )}
                        </div>
                      </div>
                      
                      <div style={{ display: 'flex', gap: '0.5rem', marginLeft: '1rem' }}>
                        <button
                          onClick={() => handleEdit(podcast)}
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
                          onClick={() => handleDeleteClick(podcast)}
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
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        {/* Podcast Form Modal */}
        {showForm && (
          <PodcastForm
            program={program}
            podcast={editingPodcast}
            onSave={handleFormSave}
            onCancel={handleFormClose}
          />
        )}

        {/* Delete Confirmation Dialog */}
        <ConfirmDialog
          isOpen={deleteDialog.isOpen}
          onClose={handleDeleteCancel}
          onConfirm={handleDeleteConfirm}
          title="Eliminar Podcast"
          message={`¿Estás seguro de que quieres eliminar el podcast "${deleteDialog.podcastTitle}"? Esta acción no se puede deshacer.`}
          confirmText="Eliminar"
          cancelText="Cancelar"
          type="danger"
        />
      </div>
    </Modal>
  );
}

// Podcast Form Component
function PodcastForm({ program, podcast = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    audio_file: null,
    duration: '',
    published_at: '',
    remove_audio: false
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});

  const isEditing = !!podcast;

  useEffect(() => {
    if (podcast) {
      setFormData({
        title: podcast.title || '',
        description: podcast.description || '',
        audio_file: null,
        duration: podcast.duration || '',
        published_at: podcast.published_at ? new Date(podcast.published_at).toISOString().slice(0, 16) : '',
        remove_audio: false
      });
    } else {
      // Set default published_at to current date/time for new podcasts
      const now = new Date();
      now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
      setFormData(prev => ({
        ...prev,
        published_at: now.toISOString().slice(0, 16)
      }));
    }
  }, [podcast]);

  const handleInputChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: type === 'checkbox' ? checked : value
    }));
    
    // Clear error when user starts typing
    if (errors[name]) {
      setErrors(prev => ({ ...prev, [name]: null }));
    }
  };

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setFormData(prev => ({ ...prev, audio_file: file, remove_audio: false }));
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      const submitData = new FormData();
      
      // Add form fields
      Object.keys(formData).forEach(key => {
        if (key === 'audio_file' && formData[key]) {
          submitData.append('audio_file', formData[key]);
        } else if (key !== 'audio_file') {
          submitData.append(key, formData[key]);
        }
      });

      if (isEditing) {
        // For Laravel, we need to use POST with _method for file uploads
        submitData.append('_method', 'PUT');
        await api.programs.podcasts.update(program.id, podcast.id, submitData);
      } else {
        await api.programs.podcasts.create(program.id, submitData);
      }

      onSave();
    } catch (err) {
      const errorInfo = handleApiError(err);
      setErrors(errorInfo.errors);
      
      if (!errorInfo.errors || Object.keys(errorInfo.errors).length === 0) {
        alert(errorInfo.message);
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <Modal
      isOpen={true}
      onClose={onCancel}
      title={isEditing ? 'Editar Podcast' : 'Nuevo Podcast'}
      size="large"
    >
      <form onSubmit={handleSubmit}>
        <div style={{ display: 'grid', gap: '1.5rem' }}>
          {/* Title */}
          <div>
            <label style={{ 
              display: 'block', 
              color: '#e5e7eb', 
              fontWeight: '600', 
              marginBottom: '0.5rem' 
            }}>
              Título del Podcast *
            </label>
            <input
              type="text"
              name="title"
              value={formData.title}
              onChange={handleInputChange}
              required
              style={{
                width: '100%',
                backgroundColor: '#374151',
                border: errors.title ? '2px solid #ef4444' : '1px solid #4b5563',
                borderRadius: '6px',
                padding: '0.75rem',
                color: '#e5e7eb',
                fontSize: '1rem'
              }}
              placeholder="Ej: Episodio 1 - Noticias de la semana"
            />
            {errors.title && (
              <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                {errors.title[0]}
              </p>
            )}
          </div>

          {/* Description */}
          <div>
            <label style={{ 
              display: 'block', 
              color: '#e5e7eb', 
              fontWeight: '600', 
              marginBottom: '0.5rem' 
            }}>
              Descripción
            </label>
            <textarea
              name="description"
              value={formData.description}
              onChange={handleInputChange}
              rows={4}
              style={{
                width: '100%',
                backgroundColor: '#374151',
                border: errors.description ? '2px solid #ef4444' : '1px solid #4b5563',
                borderRadius: '6px',
                padding: '0.75rem',
                color: '#e5e7eb',
                fontSize: '1rem',
                resize: 'vertical'
              }}
              placeholder="Describe el contenido del podcast"
            />
            {errors.description && (
              <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                {errors.description[0]}
              </p>
            )}
          </div>

          {/* Audio File */}
          <div>
            <label style={{ 
              display: 'block', 
              color: '#e5e7eb', 
              fontWeight: '600', 
              marginBottom: '0.5rem' 
            }}>
              Archivo de Audio {!isEditing && '*'}
            </label>
            <input
              type="file"
              accept="audio/*"
              onChange={handleFileChange}
              required={!isEditing}
              style={{
                width: '100%',
                backgroundColor: '#374151',
                border: errors.audio_file ? '2px solid #ef4444' : '1px solid #4b5563',
                borderRadius: '6px',
                padding: '0.75rem',
                color: '#e5e7eb',
                fontSize: '1rem'
              }}
            />
            {errors.audio_file && (
              <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                {errors.audio_file[0]}
              </p>
            )}
            <p style={{ color: '#9ca3af', fontSize: '0.8rem', marginTop: '0.25rem' }}>
              Formatos soportados: MP3, WAV, M4A. Tamaño máximo: 50MB
            </p>
          </div>

          {/* Duration and Published Date */}
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Duración
              </label>
              <input
                type="text"
                name="duration"
                value={formData.duration}
                onChange={handleInputChange}
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.duration ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
                placeholder="Ej: 45:30"
              />
              {errors.duration && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.duration[0]}
                </p>
              )}
            </div>

            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Fecha de Publicación *
              </label>
              <input
                type="datetime-local"
                name="published_at"
                value={formData.published_at}
                onChange={handleInputChange}
                required
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.published_at ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
              />
              {errors.published_at && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.published_at[0]}
                </p>
              )}
            </div>
          </div>
        </div>

        {/* Submit Buttons */}
        <div style={{ 
          display: 'flex', 
          gap: '1rem', 
          justifyContent: 'flex-end', 
          marginTop: '2rem' 
        }}>
          <button
            type="button"
            onClick={onCancel}
            disabled={loading}
            style={{
              backgroundColor: '#6b7280',
              color: 'white',
              border: 'none',
              borderRadius: '6px',
              padding: '0.75rem 1.5rem',
              cursor: loading ? 'not-allowed' : 'pointer',
              fontSize: '0.9rem',
              fontWeight: '600'
            }}
          >
            Cancelar
          </button>
          <button
            type="submit"
            disabled={loading}
            style={{
              backgroundColor: loading ? '#9ca3af' : '#2563eb',
              color: 'white',
              border: 'none',
              borderRadius: '6px',
              padding: '0.75rem 1.5rem',
              cursor: loading ? 'not-allowed' : 'pointer',
              fontSize: '0.9rem',
              fontWeight: '600',
              display: 'flex',
              alignItems: 'center',
              gap: '0.5rem'
            }}
          >
            {loading && <i className="fas fa-spinner fa-spin"></i>}
            {loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear')} Podcast
          </button>
        </div>
      </form>
    </Modal>
  );
}