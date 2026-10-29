import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { handleApiError } from '../../utils/helpers';

export default function EventForm({ event = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    event_date: '',
    event_time: '',
    location: '',
    image: null,
    is_featured: false,
    remove_image: false
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [imagePreview, setImagePreview] = useState(null);

  const isEditing = !!event;

  useEffect(() => {
    if (event) {
      setFormData({
        title: event.title || '',
        description: event.description || '',
        event_date: event.event_date || '',
        event_time: event.event_time || '',
        location: event.location || '',
        image: null,
        is_featured: event.is_featured || false,
        remove_image: false
      });
      
      if (event.image) {
        setImagePreview(`/storage/${event.image}`);
      }
    } else {
      // Set default date to today for new events
      const today = new Date().toISOString().split('T')[0];
      setFormData(prev => ({
        ...prev,
        event_date: today
      }));
    }
  }, [event]);

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

  const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setFormData(prev => ({ ...prev, image: file, remove_image: false }));
      
      // Create preview
      const reader = new FileReader();
      reader.onload = (e) => setImagePreview(e.target.result);
      reader.readAsDataURL(file);
    }
  };

  const handleRemoveImage = () => {
    setFormData(prev => ({ ...prev, image: null, remove_image: true }));
    setImagePreview(null);
  };

  const validateDate = () => {
    if (formData.event_date) {
      const eventDate = new Date(formData.event_date);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      
      if (eventDate < today) {
        setErrors(prev => ({ 
          ...prev, 
          event_date: ['La fecha del evento no puede ser anterior a hoy'] 
        }));
        return false;
      }
    }
    return true;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!validateDate()) {
      return;
    }
    
    setLoading(true);
    setErrors({});

    try {
      const submitData = new FormData();
      
      // Add form fields
      Object.keys(formData).forEach(key => {
        if (key === 'image' && formData[key]) {
          submitData.append('image', formData[key]);
        } else if (key !== 'image') {
          submitData.append(key, formData[key]);
        }
      });

      let response;
      if (isEditing) {
        response = await api.events.update(event.id, submitData);
      } else {
        response = await api.events.create(submitData);
      }

      onSave(response.data);
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
    <div>
      {/* Header */}
      <div style={{ 
        display: 'flex', 
        justifyContent: 'space-between', 
        alignItems: 'center', 
        marginBottom: '2rem' 
      }}>
        <h2 style={{ color: '#16a34a', margin: 0 }}>
          {isEditing ? 'Editar Evento' : 'Nuevo Evento'}
        </h2>
        <button
          onClick={onCancel}
          style={{
            backgroundColor: '#6b7280',
            color: 'white',
            border: 'none',
            borderRadius: '8px',
            padding: '0.75rem 1.5rem',
            cursor: 'pointer',
            fontSize: '0.9rem',
            fontWeight: '600'
          }}
        >
          Cancelar
        </button>
      </div>

      {/* Form */}
      <form onSubmit={handleSubmit}>
        <div style={{
          backgroundColor: '#1f2937',
          borderRadius: '8px',
          padding: '2rem'
        }}>
          <div style={{ display: 'grid', gap: '1.5rem' }}>
            {/* Title */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Título del Evento *
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
                placeholder="Ej: Concierto de Música Folclórica"
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
                Descripción *
              </label>
              <textarea
                name="description"
                value={formData.description}
                onChange={handleInputChange}
                required
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
                placeholder="Describe el evento, actividades, artistas participantes, etc."
              />
              {errors.description && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.description[0]}
                </p>
              )}
            </div>

            {/* Date and Time Row */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
              <div>
                <label style={{ 
                  display: 'block', 
                  color: '#e5e7eb', 
                  fontWeight: '600', 
                  marginBottom: '0.5rem' 
                }}>
                  Fecha del Evento *
                </label>
                <input
                  type="date"
                  name="event_date"
                  value={formData.event_date}
                  onChange={handleInputChange}
                  required
                  min={new Date().toISOString().split('T')[0]}
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.event_date ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                />
                {errors.event_date && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.event_date[0]}
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
                  Hora del Evento *
                </label>
                <input
                  type="time"
                  name="event_time"
                  value={formData.event_time}
                  onChange={handleInputChange}
                  required
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.event_time ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                />
                {errors.event_time && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.event_time[0]}
                  </p>
                )}
              </div>
            </div>

            {/* Location */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Ubicación *
              </label>
              <input
                type="text"
                name="location"
                value={formData.location}
                onChange={handleInputChange}
                required
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.location ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
                placeholder="Ej: Plaza Principal de Umachiri"
              />
              {errors.location && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.location[0]}
                </p>
              )}
            </div>

            {/* Featured Checkbox */}
            <div>
              <label style={{
                display: 'flex',
                alignItems: 'center',
                gap: '0.75rem',
                backgroundColor: '#374151',
                border: '1px solid #4b5563',
                borderRadius: '6px',
                padding: '1rem',
                cursor: 'pointer',
                color: '#e5e7eb'
              }}>
                <input
                  type="checkbox"
                  name="is_featured"
                  checked={formData.is_featured}
                  onChange={handleInputChange}
                  style={{ 
                    width: '1.2rem', 
                    height: '1.2rem',
                    accentColor: '#16a34a'
                  }}
                />
                <div>
                  <div style={{ fontWeight: '600', marginBottom: '0.25rem' }}>
                    <i className="fas fa-star" style={{ color: '#f59e0b', marginRight: '0.5rem' }}></i>
                    Evento Destacado
                  </div>
                  <div style={{ fontSize: '0.8rem', color: '#9ca3af' }}>
                    Los eventos destacados aparecen en la página principal y tienen mayor visibilidad
                  </div>
                </div>
              </label>
            </div>

            {/* Image Upload */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Imagen Promocional
              </label>
              
              {imagePreview && (
                <div style={{ marginBottom: '1rem' }}>
                  <img 
                    src={imagePreview} 
                    alt="Preview" 
                    style={{ 
                      maxWidth: '300px', 
                      maxHeight: '200px', 
                      borderRadius: '6px',
                      objectFit: 'cover'
                    }} 
                  />
                  <button
                    type="button"
                    onClick={handleRemoveImage}
                    style={{
                      backgroundColor: '#ef4444',
                      color: 'white',
                      border: 'none',
                      borderRadius: '4px',
                      padding: '0.25rem 0.5rem',
                      cursor: 'pointer',
                      fontSize: '0.8rem',
                      marginLeft: '1rem'
                    }}
                  >
                    Eliminar imagen
                  </button>
                </div>
              )}
              
              <input
                type="file"
                accept="image/*"
                onChange={handleImageChange}
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.image ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
              />
              {errors.image && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.image[0]}
                </p>
              )}
              <p style={{ color: '#9ca3af', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                Formatos soportados: JPG, PNG, GIF. Tamaño máximo: 2MB. Recomendado: 800x600px
              </p>
            </div>

            {/* Event Info Box */}
            <div style={{
              backgroundColor: '#065f46',
              border: '1px solid #16a34a',
              borderRadius: '6px',
              padding: '1rem'
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.5rem' }}>
                <i className="fas fa-info-circle" style={{ color: '#16a34a' }}></i>
                <span style={{ color: '#16a34a', fontWeight: '600' }}>Información del Evento</span>
              </div>
              <div style={{ color: '#d1fae5', fontSize: '0.9rem', lineHeight: '1.4' }}>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Los eventos se mostrarán automáticamente en la página de eventos públicos
                </p>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Los eventos destacados aparecen en la página principal
                </p>
                <p style={{ margin: '0' }}>
                  • Asegúrate de incluir toda la información relevante para los asistentes
                </p>
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
                backgroundColor: loading ? '#9ca3af' : '#16a34a',
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
              {loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear')} Evento
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}