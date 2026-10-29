import React, { useState, useEffect, useRef } from 'react';
import { api } from '../../utils/api';
import { handleApiError } from '../../utils/helpers';

export default function GalleryForm({ gallery = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    images: [],
    existingImages: []
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [dragOver, setDragOver] = useState(false);
  const fileInputRef = useRef(null);

  const isEditing = !!gallery;

  useEffect(() => {
    if (gallery) {
      setFormData({
        title: gallery.title || '',
        description: gallery.description || '',
        images: [],
        existingImages: gallery.images || []
      });
    }
  }, [gallery]);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
    
    // Clear error when user starts typing
    if (errors[name]) {
      setErrors(prev => ({ ...prev, [name]: null }));
    }
  };

  const handleFileSelect = (files) => {
    const validFiles = Array.from(files).filter(file => {
      const isImage = file.type.startsWith('image/');
      const isValidSize = file.size <= 2 * 1024 * 1024; // 2MB
      return isImage && isValidSize;
    });

    if (validFiles.length !== files.length) {
      alert('Algunos archivos fueron omitidos. Solo se permiten imágenes de máximo 2MB.');
    }

    setFormData(prev => ({
      ...prev,
      images: [...prev.images, ...validFiles]
    }));
  };

  const handleFileInputChange = (e) => {
    if (e.target.files.length > 0) {
      handleFileSelect(e.target.files);
    }
  };

  const handleDragOver = (e) => {
    e.preventDefault();
    setDragOver(true);
  };

  const handleDragLeave = (e) => {
    e.preventDefault();
    setDragOver(false);
  };

  const handleDrop = (e) => {
    e.preventDefault();
    setDragOver(false);
    
    if (e.dataTransfer.files.length > 0) {
      handleFileSelect(e.dataTransfer.files);
    }
  };

  const removeNewImage = (index) => {
    setFormData(prev => ({
      ...prev,
      images: prev.images.filter((_, i) => i !== index)
    }));
  };

  const removeExistingImage = (imagePath) => {
    setFormData(prev => ({
      ...prev,
      existingImages: prev.existingImages.filter(img => img !== imagePath)
    }));
  };

  const reorderExistingImages = (fromIndex, toIndex) => {
    setFormData(prev => {
      const newImages = [...prev.existingImages];
      const [movedImage] = newImages.splice(fromIndex, 1);
      newImages.splice(toIndex, 0, movedImage);
      return { ...prev, existingImages: newImages };
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setErrors({});

    try {
      const submitData = new FormData();
      
      // Add form fields
      submitData.append('title', formData.title);
      submitData.append('description', formData.description);
      
      // Add new images
      formData.images.forEach((image, index) => {
        submitData.append(`images[${index}]`, image);
      });

      let response;
      if (isEditing) {
        // For editing, we need to handle existing images separately
        if (formData.existingImages.length > 0) {
          submitData.append('existing_images', JSON.stringify(formData.existingImages));
        }
        
        response = await api.galleries.update(gallery.id, submitData);
      } else {
        response = await api.galleries.create(submitData);
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

  const getTotalImageCount = () => {
    return formData.images.length + formData.existingImages.length;
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
        <h2 style={{ color: '#f59e0b', margin: 0 }}>
          {isEditing ? 'Editar Galería' : 'Nueva Galería'}
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
                Título de la Galería *
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
                placeholder="Ej: Concierto de Aniversario 2024"
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
                rows={3}
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
                placeholder="Describe la galería, el evento o las fotos que contiene"
              />
              {errors.description && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.description[0]}
                </p>
              )}
            </div>

            {/* Image Upload Area */}
            <div>
              <label style={{ 
                display: 'block', 
                color: '#e5e7eb', 
                fontWeight: '600', 
                marginBottom: '0.5rem' 
              }}>
                Imágenes {!isEditing && '*'}
              </label>
              
              {/* Drag & Drop Area */}
              <div
                onDragOver={handleDragOver}
                onDragLeave={handleDragLeave}
                onDrop={handleDrop}
                onClick={() => fileInputRef.current?.click()}
                style={{
                  border: dragOver 
                    ? '2px dashed #f59e0b' 
                    : errors.images 
                      ? '2px dashed #ef4444' 
                      : '2px dashed #4b5563',
                  borderRadius: '8px',
                  padding: '2rem',
                  textAlign: 'center',
                  backgroundColor: dragOver ? '#374151' : '#374151',
                  cursor: 'pointer',
                  transition: 'all 0.2s ease'
                }}
              >
                <i className="fas fa-cloud-upload-alt" style={{ 
                  fontSize: '3rem', 
                  color: dragOver ? '#f59e0b' : '#9ca3af',
                  marginBottom: '1rem'
                }}></i>
                <p style={{ 
                  color: dragOver ? '#f59e0b' : '#e5e7eb', 
                  margin: '0 0 0.5rem 0',
                  fontSize: '1.1rem',
                  fontWeight: '600'
                }}>
                  {dragOver ? 'Suelta las imágenes aquí' : 'Arrastra imágenes aquí o haz clic para seleccionar'}
                </p>
                <p style={{ 
                  color: '#9ca3af', 
                  margin: 0,
                  fontSize: '0.9rem'
                }}>
                  Formatos soportados: JPG, PNG, GIF. Máximo 2MB por imagen.
                </p>
                <p style={{ 
                  color: '#6b7280', 
                  margin: '0.5rem 0 0 0',
                  fontSize: '0.8rem'
                }}>
                  Imágenes seleccionadas: {getTotalImageCount()}
                </p>
              </div>

              <input
                ref={fileInputRef}
                type="file"
                accept="image/*"
                multiple
                onChange={handleFileInputChange}
                style={{ display: 'none' }}
              />

              {errors.images && (
                <p style={{ color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }}>
                  {errors.images[0]}
                </p>
              )}
            </div>

            {/* Existing Images (for editing) */}
            {isEditing && formData.existingImages.length > 0 && (
              <div>
                <h3 style={{ color: '#e5e7eb', marginBottom: '1rem' }}>
                  Imágenes Actuales ({formData.existingImages.length})
                </h3>
                <div style={{
                  display: 'grid',
                  gridTemplateColumns: 'repeat(auto-fill, minmax(150px, 1fr))',
                  gap: '1rem'
                }}>
                  {formData.existingImages.map((imagePath, index) => (
                    <div key={imagePath} style={{
                      position: 'relative',
                      backgroundColor: '#374151',
                      borderRadius: '8px',
                      overflow: 'hidden'
                    }}>
                      <img
                        src={`/storage/${imagePath}`}
                        alt={`Imagen ${index + 1}`}
                        style={{
                          width: '100%',
                          height: '120px',
                          objectFit: 'cover'
                        }}
                      />
                      <button
                        type="button"
                        onClick={() => removeExistingImage(imagePath)}
                        style={{
                          position: 'absolute',
                          top: '0.25rem',
                          right: '0.25rem',
                          backgroundColor: '#ef4444',
                          color: 'white',
                          border: 'none',
                          borderRadius: '50%',
                          width: '24px',
                          height: '24px',
                          cursor: 'pointer',
                          fontSize: '0.7rem',
                          display: 'flex',
                          alignItems: 'center',
                          justifyContent: 'center'
                        }}
                        title="Eliminar imagen"
                      >
                        <i className="fas fa-times"></i>
                      </button>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* New Images Preview */}
            {formData.images.length > 0 && (
              <div>
                <h3 style={{ color: '#e5e7eb', marginBottom: '1rem' }}>
                  Nuevas Imágenes ({formData.images.length})
                </h3>
                <div style={{
                  display: 'grid',
                  gridTemplateColumns: 'repeat(auto-fill, minmax(150px, 1fr))',
                  gap: '1rem'
                }}>
                  {formData.images.map((file, index) => (
                    <div key={index} style={{
                      position: 'relative',
                      backgroundColor: '#374151',
                      borderRadius: '8px',
                      overflow: 'hidden'
                    }}>
                      <img
                        src={URL.createObjectURL(file)}
                        alt={`Nueva imagen ${index + 1}`}
                        style={{
                          width: '100%',
                          height: '120px',
                          objectFit: 'cover'
                        }}
                      />
                      <button
                        type="button"
                        onClick={() => removeNewImage(index)}
                        style={{
                          position: 'absolute',
                          top: '0.25rem',
                          right: '0.25rem',
                          backgroundColor: '#ef4444',
                          color: 'white',
                          border: 'none',
                          borderRadius: '50%',
                          width: '24px',
                          height: '24px',
                          cursor: 'pointer',
                          fontSize: '0.7rem',
                          display: 'flex',
                          alignItems: 'center',
                          justifyContent: 'center'
                        }}
                        title="Eliminar imagen"
                      >
                        <i className="fas fa-times"></i>
                      </button>
                      <div style={{
                        position: 'absolute',
                        bottom: '0.25rem',
                        left: '0.25rem',
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        color: 'white',
                        padding: '0.125rem 0.25rem',
                        borderRadius: '4px',
                        fontSize: '0.7rem'
                      }}>
                        {(file.size / 1024 / 1024).toFixed(1)}MB
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* Gallery Info */}
            <div style={{
              backgroundColor: '#065f46',
              border: '1px solid #f59e0b',
              borderRadius: '6px',
              padding: '1rem'
            }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginBottom: '0.5rem' }}>
                <i className="fas fa-info-circle" style={{ color: '#f59e0b' }}></i>
                <span style={{ color: '#f59e0b', fontWeight: '600' }}>Información de la Galería</span>
              </div>
              <div style={{ color: '#fef3c7', fontSize: '0.9rem', lineHeight: '1.4' }}>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Las galerías se mostrarán automáticamente en la página de galerías públicas
                </p>
                <p style={{ margin: '0 0 0.5rem 0' }}>
                  • Puedes subir múltiples imágenes a la vez arrastrándolas o seleccionándolas
                </p>
                <p style={{ margin: '0' }}>
                  • Las imágenes se optimizarán automáticamente para web
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
              disabled={loading || (!isEditing && formData.images.length === 0)}
              style={{
                backgroundColor: loading || (!isEditing && formData.images.length === 0) ? '#9ca3af' : '#f59e0b',
                color: 'white',
                border: 'none',
                borderRadius: '6px',
                padding: '0.75rem 1.5rem',
                cursor: loading || (!isEditing && formData.images.length === 0) ? 'not-allowed' : 'pointer',
                fontSize: '0.9rem',
                fontWeight: '600',
                display: 'flex',
                alignItems: 'center',
                gap: '0.5rem'
              }}
            >
              {loading && <i className="fas fa-spinner fa-spin"></i>}
              {loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear')} Galería
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}