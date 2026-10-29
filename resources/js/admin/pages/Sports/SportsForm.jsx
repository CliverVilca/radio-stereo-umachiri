import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { handleApiError } from '../../utils/helpers';

export default function SportsForm({ sport = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    title: '',
    content: '',
    author: '',
    category: 'futbol',
    published_at: '',
    status: 'draft',
    is_featured: false,
    image: null,
    remove_image: false
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [imagePreview, setImagePreview] = useState(null);

  const isEditing = !!sport;

  const categories = [
    { value: 'futbol', label: 'Fútbol' },
    { value: 'basquet', label: 'Básquet' },
    { value: 'voleibol', label: 'Vóleibol' },
    { value: 'atletismo', label: 'Atletismo' },
    { value: 'otros', label: 'Otros' }
  ];

  useEffect(() => {
    if (sport) {
      setFormData({
        title: sport.title || '',
        content: sport.content || '',
        author: sport.author || '',
        category: sport.category || 'futbol',
        published_at: sport.published_at ? new Date(sport.published_at).toISOString().slice(0, 16) : '',
        status: sport.status || 'draft',
        is_featured: sport.is_featured || false,
        image: null,
        remove_image: false
      });
      
      if (sport.image) {
        setImagePreview(`/storage/${sport.image}`);
      }
    } else {
      // Set default published_at to current date/time for new sports
      const now = new Date();
      now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
      setFormData(prev => ({
        ...prev,
        published_at: now.toISOString().slice(0, 16)
      }));
    }
  }, [sport]);

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

  const handleSubmit = async (e) => {
    e.preventDefault();
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
        response = await api.sports.update(sport.id, submitData);
      } else {
        response = await api.sports.create(submitData);
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
        <h2 style={{ color: '#f97316', margin: 0 }}>
          {isEditing ? 'Editar Noticia Deportiva' : 'Nueva Noticia Deportiva'}
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
                Título de la Noticia *
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
                placeholder="Ej: Victoria del equipo local en el campeonato"
              />
              {errors.title && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.title[0]}
                </p>
              )}
            </div>

            {/* Content */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Contenido *
              </label>
              <textarea
                name="content"
                value={formData.content}
                onChange={handleInputChange}
                required
                rows={8}
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.content ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem',
                  resize: 'vertical'
                }}
                placeholder="Escribe el contenido completo de la noticia deportiva..."
              />
              {errors.content && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.content[0]}
                </p>
              )}
            </div>

            {/* Author and Category Row */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
              <div>
                <label style={{ 
                  display: 'block', 
                  color: '#e5e7eb', 
                  fontWeight: '600', 
                  marginBottom: '0.5rem' 
                }}>
                  Autor *
                </label>
                <input
                  type="text"
                  name="author"
                  value={formData.author}
                  onChange={handleInputChange}
                  required
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.author ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                  placeholder="Nombre del autor"
                />
                {errors.author && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.author[0]}
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
                  Categoría Deportiva *
                </label>
                <select
                  name="category"
                  value={formData.category}
                  onChange={handleInputChange}
                  required
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.category ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                >
                  {categories.map(category => (
                    <option key={category.value} value={category.value}>
                      {category.label}
                    </option>
                  ))}
                </select>
                {errors.category && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.category[0]}
                  </p>
                )}
              </div>
            </div>

            {/* Published Date and Status Row */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
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

              <div>
                <label style={{ 
                  display: 'block', 
                  color: '#e5e7eb', 
                  fontWeight: '600', 
                  marginBottom: '0.5rem' 
                }}>
                  Estado *
                </label>
                <select
                  name="status"
                  value={formData.status}
                  onChange={handleInputChange}
                  required
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.status ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                >
                  <option value="draft">Borrador</option>
                  <option value="published">Publicado</option>
                </select>
                {errors.status && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.status[0]}
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
                    accentColor: '#f97316'
                  }}
                />
                <div>
                  <div style={{ fontWeight: '600', marginBottom: '0.25rem' }}>
                    <i className="fas fa-star" style={{ color: '#f59e0b', marginRight: '0.5rem' }}></i>
                    Noticia Destacada
                  </div>
                  <div style={{ fontSize: '0.8rem', color: '#9ca3af' }}>
                    Las noticias destacadas aparecen en la página principal y tienen mayor visibilidad
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
                Imagen de la Noticia
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

            {/* Sports Info Box */}
            <div style={{
              backgroundColor: '#065f46',
              border: '1px solid #f97316',
              borderRadius: '6px',
              padding: '1rem'
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.5rem' }}>
                <i className="fas fa-info-circle" style={{ color: '#f97316' }}></i>
                <span style={{ color: '#f97316', fontWeight: '600' }}>Información de la Noticia Deportiva</span>
              </div>
              <div style={{ color: '#fef3c7', fontSize: '0.9rem', lineHeight: '1.4' }}>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Las noticias deportivas se mostrarán automáticamente en la sección de deportes
                </p>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Las noticias destacadas aparecen en la página principal
                </p>
                <p style={{ margin: '0' }}>
                  • Puedes categorizar por deporte para mejor organización
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
                backgroundColor: loading ? '#9ca3af' : '#f97316',
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
              {loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear')} Noticia
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}