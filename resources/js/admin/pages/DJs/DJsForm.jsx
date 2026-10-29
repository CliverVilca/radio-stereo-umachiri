import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { handleApiError } from '../../utils/helpers';

export default function DJsForm({ dj = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    name: '',
    bio: '',
    specialties: '',
    email: '',
    phone: '',
    social_media: {
      facebook: '',
      instagram: '',
      twitter: '',
      youtube: ''
    },
    status: 'active',
    is_featured: false,
    photo: null,
    remove_photo: false
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [photoPreview, setPhotoPreview] = useState(null);

  const isEditing = !!dj;

  useEffect(() => {
    if (dj) {
      setFormData({
        name: dj.name || '',
        bio: dj.bio || '',
        specialties: dj.specialties || '',
        email: dj.email || '',
        phone: dj.phone || '',
        social_media: dj.social_media || {
          facebook: '',
          instagram: '',
          twitter: '',
          youtube: ''
        },
        status: dj.status || 'active',
        is_featured: dj.is_featured || false,
        photo: null,
        remove_photo: false
      });
      
      if (dj.photo) {
        setPhotoPreview(`/storage/${dj.photo}`);
      }
    }
  }, [dj]);

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

  const handleSocialMediaChange = (platform, value) => {
    setFormData(prev => ({
      ...prev,
      social_media: {
        ...prev.social_media,
        [platform]: value
      }
    }));
  };

  const handlePhotoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setFormData(prev => ({ ...prev, photo: file, remove_photo: false }));
      
      // Create preview
      const reader = new FileReader();
      reader.onload = (e) => setPhotoPreview(e.target.result);
      reader.readAsDataURL(file);
    }
  };

  const handleRemovePhoto = () => {
    setFormData(prev => ({ ...prev, photo: null, remove_photo: true }));
    setPhotoPreview(null);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      const submitData = new FormData();
      
      // Add form fields
      Object.keys(formData).forEach(key => {
        if (key === 'photo' && formData[key]) {
          submitData.append('photo', formData[key]);
        } else if (key === 'social_media') {
          submitData.append('social_media', JSON.stringify(formData[key]));
        } else if (key !== 'photo') {
          submitData.append(key, formData[key]);
        }
      });

      let response;
      if (isEditing) {
        response = await api.djs.update(dj.id, submitData);
      } else {
        response = await api.djs.create(submitData);
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
        <h2 style={{ color: '#8b5cf6', margin: 0 }}>
          {isEditing ? 'Editar DJ' : 'Nuevo DJ'}
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
            {/* Name */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Nombre del DJ *
              </label>
              <input
                type="text"
                name="name"
                value={formData.name}
                onChange={handleInputChange}
                required
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.name ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
                placeholder="Ej: DJ Carlos Mendoza"
              />
              {errors.name && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.name[0]}
                </p>
              )}
            </div>

            {/* Bio */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Biografía
              </label>
              <textarea
                name="bio"
                value={formData.bio}
                onChange={handleInputChange}
                rows={4}
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.bio ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem',
                  resize: 'vertical'
                }}
                placeholder="Describe la experiencia, estilo y trayectoria del DJ..."
              />
              {errors.bio && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.bio[0]}
                </p>
              )}
            </div>

            {/* Specialties */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Especialidades Musicales
              </label>
              <input
                type="text"
                name="specialties"
                value={formData.specialties}
                onChange={handleInputChange}
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.specialties ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
                placeholder="Ej: Salsa, Cumbia, Rock, Electrónica"
              />
              {errors.specialties && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.specialties[0]}
                </p>
              )}
            </div>

            {/* Contact Info Row */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
              <div>
                <label style={{ 
                  display: 'block', 
                  color: '#e5e7eb', 
                  fontWeight: '600', 
                  marginBottom: '0.5rem' 
                }}>
                  Email
                </label>
                <input
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.email ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                  placeholder="dj@ejemplo.com"
                />
                {errors.email && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.email[0]}
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
                  Teléfono
                </label>
                <input
                  type="tel"
                  name="phone"
                  value={formData.phone}
                  onChange={handleInputChange}
                  style={{
                    width: '100%',
                    backgroundColor: '#374151',
                    border: errors.phone ? '2px solid #ef4444' : '1px solid #4b5563',
                    borderRadius: '6px',
                    padding: '0.75rem',
                    color: '#e5e7eb',
                    fontSize: '1rem'
                  }}
                  placeholder="+51 999 888 777"
                />
                {errors.phone && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.phone[0]}
                  </p>
                )}
              </div>
            </div>

            {/* Social Media */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Redes Sociales
              </label>
              <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                <div>
                  <label style={{ 
                    display: 'block', 
                    color: '#9ca3af', 
                    fontSize: '0.8rem', 
                    marginBottom: '0.25rem' 
                  }}>
                    <i className="fab fa-facebook" style={{ marginRight: '0.5rem', color: '#1877f2' }}></i>
                    Facebook
                  </label>
                  <input
                    type="url"
                    value={formData.social_media.facebook}
                    onChange={(e) => handleSocialMediaChange('facebook', e.target.value)}
                    style={{
                      width: '100%',
                      backgroundColor: '#374151',
                      border: '1px solid #4b5563',
                      borderRadius: '6px',
                      padding: '0.5rem',
                      color: '#e5e7eb',
                      fontSize: '0.9rem'
                    }}
                    placeholder="https://facebook.com/dj-nombre"
                  />
                </div>

                <div>
                  <label style={{ 
                    display: 'block', 
                    color: '#9ca3af', 
                    fontSize: '0.8rem', 
                    marginBottom: '0.25rem' 
                  }}>
                    <i className="fab fa-instagram" style={{ marginRight: '0.5rem', color: '#e4405f' }}></i>
                    Instagram
                  </label>
                  <input
                    type="url"
                    value={formData.social_media.instagram}
                    onChange={(e) => handleSocialMediaChange('instagram', e.target.value)}
                    style={{
                      width: '100%',
                      backgroundColor: '#374151',
                      border: '1px solid #4b5563',
                      borderRadius: '6px',
                      padding: '0.5rem',
                      color: '#e5e7eb',
                      fontSize: '0.9rem'
                    }}
                    placeholder="https://instagram.com/dj-nombre"
                  />
                </div>

                <div>
                  <label style={{ 
                    display: 'block', 
                    color: '#9ca3af', 
                    fontSize: '0.8rem', 
                    marginBottom: '0.25rem' 
                  }}>
                    <i className="fab fa-twitter" style={{ marginRight: '0.5rem', color: '#1da1f2' }}></i>
                    Twitter
                  </label>
                  <input
                    type="url"
                    value={formData.social_media.twitter}
                    onChange={(e) => handleSocialMediaChange('twitter', e.target.value)}
                    style={{
                      width: '100%',
                      backgroundColor: '#374151',
                      border: '1px solid #4b5563',
                      borderRadius: '6px',
                      padding: '0.5rem',
                      color: '#e5e7eb',
                      fontSize: '0.9rem'
                    }}
                    placeholder="https://twitter.com/dj-nombre"
                  />
                </div>

                <div>
                  <label style={{ 
                    display: 'block', 
                    color: '#9ca3af', 
                    fontSize: '0.8rem', 
                    marginBottom: '0.25rem' 
                  }}>
                    <i className="fab fa-youtube" style={{ marginRight: '0.5rem', color: '#ff0000' }}></i>
                    YouTube
                  </label>
                  <input
                    type="url"
                    value={formData.social_media.youtube}
                    onChange={(e) => handleSocialMediaChange('youtube', e.target.value)}
                    style={{
                      width: '100%',
                      backgroundColor: '#374151',
                      border: '1px solid #4b5563',
                      borderRadius: '6px',
                      padding: '0.5rem',
                      color: '#e5e7eb',
                      fontSize: '0.9rem'
                    }}
                    placeholder="https://youtube.com/c/dj-nombre"
                  />
                </div>
              </div>
            </div>

            {/* Status and Featured Row */}
            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
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
                  <option value="active">Activo</option>
                  <option value="inactive">Inactivo</option>
                </select>
                {errors.status && (
                  <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                    {errors.status[0]}
                  </p>
                )}
              </div>

              <div style={{ display: 'flex', alignItems: 'end' }}>
                <label style={{
                  display: 'flex',
                  alignItems: 'center',
                  gap: '0.75rem',
                  backgroundColor: '#374151',
                  border: '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '1rem',
                  cursor: 'pointer',
                  color: '#e5e7eb',
                  width: '100%'
                }}>
                  <input
                    type="checkbox"
                    name="is_featured"
                    checked={formData.is_featured}
                    onChange={handleInputChange}
                    style={{ 
                      width: '1.2rem', 
                      height: '1.2rem',
                      accentColor: '#8b5cf6'
                    }}
                  />
                  <div>
                    <div style={{ fontWeight: '600', marginBottom: '0.25rem' }}>
                      <i className="fas fa-star" style={{ color: '#f59e0b', marginRight: '0.5rem' }}></i>
                      DJ Destacado
                    </div>
                    <div style={{ fontSize: '0.8rem', color: '#9ca3af' }}>
                      Los DJs destacados aparecen en la página principal
                    </div>
                  </div>
                </label>
              </div>
            </div>

            {/* Photo Upload */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Foto del DJ
              </label>
              
              {photoPreview && (
                <div style={{ marginBottom: '1rem' }}>
                  <img 
                    src={photoPreview} 
                    alt="Preview" 
                    style={{ 
                      maxWidth: '200px', 
                      maxHeight: '200px', 
                      borderRadius: '50%',
                      objectFit: 'cover'
                    }} 
                  />
                  <button
                    type="button"
                    onClick={handleRemovePhoto}
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
                    Eliminar foto
                  </button>
                </div>
              )}
              
              <input
                type="file"
                accept="image/*"
                onChange={handlePhotoChange}
                style={{
                  width: '100%',
                  backgroundColor: '#374151',
                  border: errors.photo ? '2px solid #ef4444' : '1px solid #4b5563',
                  borderRadius: '6px',
                  padding: '0.75rem',
                  color: '#e5e7eb',
                  fontSize: '1rem'
                }}
              />
              {errors.photo && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.photo[0]}
                </p>
              )}
              <p style={{ color: '#9ca3af', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                Formatos soportados: JPG, PNG, GIF. Tamaño máximo: 2MB. Recomendado: foto cuadrada 400x400px
              </p>
            </div>

            {/* DJ Info Box */}
            <div style={{
              backgroundColor: '#065f46',
              border: '1px solid #8b5cf6',
              borderRadius: '6px',
              padding: '1rem'
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.5rem' }}>
                <i className="fas fa-info-circle" style={{ color: '#8b5cf6' }}></i>
                <span style={{ color: '#8b5cf6', fontWeight: '600' }}>Información del DJ</span>
              </div>
              <div style={{ color: '#fef3c7', fontSize: '0.9rem', lineHeight: '1.4' }}>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Los DJs se mostrarán automáticamente en la página del equipo
                </p>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Los DJs destacados aparecen en la página principal
                </p>
                <p style={{ margin: '0' }}>
                  • Puedes asignar DJs a programas específicos desde la gestión de programas
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
                backgroundColor: loading ? '#9ca3af' : '#8b5cf6',
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
              {loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear')} DJ
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}