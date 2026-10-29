import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { handleApiError } from '../../utils/helpers';

export default function ProgramForm({ program = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    host: '',
    days_of_week: [],
    start_time: '',
    end_time: '',
    image: null,
    is_featured: false,
    remove_image: false
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [imagePreview, setImagePreview] = useState(null);

  const isEditing = !!program;
  const daysOfWeek = [
    { label: 'Lunes', value: 'monday' },
    { label: 'Martes', value: 'tuesday' },
    { label: 'Miércoles', value: 'wednesday' },
    { label: 'Jueves', value: 'thursday' },
    { label: 'Viernes', value: 'friday' },
    { label: 'Sábado', value: 'saturday' },
    { label: 'Domingo', value: 'sunday' }
  ];

  useEffect(() => {
    if (program) {
      setFormData({
        title: program.title || '',
        description: program.description || '',
        host: program.host || '',
        days_of_week: program.days_of_week || [],
        start_time: program.start_time || '',
        end_time: program.end_time || '',
        image: null,
        is_featured: program.is_featured || false,
        remove_image: false
      });
      
      if (program.image) {
        setImagePreview(`/storage/${program.image}`);
      }
    }
  }, [program]);

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

  const handleDayToggle = (dayValue) => {
    setFormData(prev => ({
      ...prev,
      days_of_week: prev.days_of_week.includes(dayValue)
        ? prev.days_of_week.filter(d => d !== dayValue)
        : [...prev.days_of_week, dayValue]
    }));
    
    // Clear error when user changes days
    if (errors.days_of_week) {
      setErrors(prev => ({ ...prev, days_of_week: null }));
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

  const validateTimeRange = () => {
    if (formData.start_time && formData.end_time) {
      const start = new Date(`2000-01-01T${formData.start_time}`);
      const end = new Date(`2000-01-01T${formData.end_time}`);
      
      if (start >= end) {
        setErrors(prev => ({ 
          ...prev, 
          end_time: ['La hora de fin debe ser posterior a la hora de inicio'] 
        }));
        return false;
      }
    }
    return true;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!validateTimeRange()) {
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
        } else if (key === 'days_of_week') {
          // Send as JSON array
          formData[key].forEach((day, index) => {
            submitData.append(`days_of_week[${index}]`, day);
          });
        } else if (key !== 'image') {
          submitData.append(key, formData[key]);
        }
      });

      let response;
      if (isEditing) {
        response = await api.programs.update(program.id, submitData);
      } else {
        response = await api.programs.create(submitData);
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
        <h2 style={{ color: '#2563eb', margin: 0 }}>
          {isEditing ? 'Editar Programa' : 'Nuevo Programa'}
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
                Título del Programa *
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
                placeholder="Ej: Buenos Días Umachiri"
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
                placeholder="Describe el programa, su contenido y audiencia objetivo"
              />
              {errors.description && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.description[0]}
                </p>
              )}
            </div>

            {/* Host */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Conductor/a *
              </label>
              <input
                type="text"
                name="host"
                value={formData.host}
                onChange={handleInputChange}
                required
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.host ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
                placeholder="Nombre del conductor o conductora"
              />
              {errors.host && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.host[0]}
                </p>
              )}
            </div>

            {/* Days of Week */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Días de la Semana *
              </label>
              <div style={{
                display: 'grid',
                gridTemplateColumns: 'repeat(auto-fit, minmax(120px, 1fr))',
                gap: '0.5rem',
                marginBottom: '0.5rem'
              }}>
                {daysOfWeek.map(day => (
                  <label
                    key={day.value}
                    style={{
                      display: 'flex',
                      alignItems: 'center',
                      gap: '0.5rem',
                      backgroundColor: formData.days_of_week.includes(day.value) ? '#2563eb' : '#374151',
                      border: errors.days_of_week ? '2px solid #ef4444' : '1px solid #4b5563',
                      borderRadius: '6px',
                      padding: '0.75rem',
                      cursor: 'pointer',
                      transition: 'all 0.2s',
                      color: '#e5e7eb'
                    }}
                  >
                    <input
                      type="checkbox"
                      checked={formData.days_of_week.includes(day.value)}
                      onChange={() => handleDayToggle(day.value)}
                      style={{ margin: 0 }}
                    />
                    <span style={{ fontSize: '0.9rem', fontWeight: '500' }}>{day.label}</span>
                  </label>
                ))}
              </div>
              {errors.days_of_week && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.days_of_week[0]}
                </p>
              )}
              <p style={{ color: '#9ca3af', fontSize: '0.8rem' }}>
                Selecciona los días en que se transmite el programa
              </p>
            </div>

            {/* Time Range */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
              <div>
                <label style={{ 
                  display: 'block', 
                  color: '#e5e7eb', 
                  fontWeight: '600', 
                  marginBottom: '0.5rem' 
                }}>
                  Hora de Inicio *
                </label>
                <input
                  type="time"
                  name="start_time"
                  value={formData.start_time}
                  onChange={handleInputChange}
                  required
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.start_time ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                />
                {errors.start_time && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.start_time[0]}
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
                  Hora de Fin *
                </label>
                <input
                  type="time"
                  name="end_time"
                  value={formData.end_time}
                  onChange={handleInputChange}
                  required
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.end_time ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                />
                {errors.end_time && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.end_time[0]}
                  </p>
                )}
              </div>
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
                    accentColor: '#2563eb'
                  }}
                />
                <div>
                  <div style={{ fontWeight: '600', marginBottom: '0.25rem' }}>
                    <i className="fas fa-star" style={{ color: '#f59e0b', marginRight: '0.5rem' }}></i>
                    Programa Destacado
                  </div>
                  <div style={{ fontSize: '0.8rem', color: '#9ca3af' }}>
                    Los programas destacados aparecen en la página principal
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
                Imagen del Programa
              </label>
              
              {imagePreview && (
                <div style={{ marginBottom: '1rem' }}>
                  <img 
                    src={imagePreview} 
                    alt="Preview" 
                    style={{ 
                      maxWidth: '200px', 
                      maxHeight: '150px', 
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
                Formatos soportados: JPG, PNG, GIF. Tamaño máximo: 2MB
              </p>
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
              {loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear')} Programa
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}