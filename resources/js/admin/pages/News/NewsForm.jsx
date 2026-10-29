import React, { useState, useEffect } from 'react';
import { api } from '../../utils/api';
import { handleApiError } from '../../utils/helpers';
import ResponsiveForm, { FormField, FormInput, FormTextarea, FormSelect } from '../../components/ResponsiveForm';

export default function NewsForm({ news = null, onSave, onCancel }) {
  const [formData, setFormData] = useState({
    title: '',
    content: '',
    author: '',
    published_at: '',
    type: 'local',
    status: 'draft',
    image: null,
    remove_image: false
  });
  const [loading, setLoading] = useState(false);
  const [errors, setErrors] = useState({});
  const [imagePreview, setImagePreview] = useState(null);

  const isEditing = !!news;

  useEffect(() => {
    if (news) {
      setFormData({
        title: news.title || '',
        content: news.content || '',
        author: news.author || '',
        published_at: news.published_at ? new Date(news.published_at).toISOString().slice(0, 16) : '',
        type: news.type || 'local',
        status: news.status || 'draft',
        image: null,
        remove_image: false
      });
      
      if (news.image) {
        setImagePreview(`/storage/${news.image}`);
      }
    } else {
      // Set default published_at to current date/time for new news
      const now = new Date();
      now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
      setFormData(prev => ({
        ...prev,
        published_at: now.toISOString().slice(0, 16)
      }));
    }
  }, [news]);

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
        response = await api.news.update(news.id, submitData);
      } else {
        response = await api.news.create(submitData);
      }

      onSave(response.data.data);
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
    <ResponsiveForm
      title={isEditing ? 'Editar Noticia' : 'Nueva Noticia'}
      onSubmit={handleSubmit}
      onCancel={onCancel}
      loading={loading}
      submitText={isEditing ? 'Actualizar Noticia' : 'Crear Noticia'}
    >
      {/* Title */}
      <FormField label="Título" required error={errors.title?.[0]} fullWidth>
        <FormInput
          name="title"
          value={formData.title}
          onChange={handleInputChange}
          placeholder="Ingresa el título de la noticia"
          required
        />
      </FormField>

      {/* Content */}
      <FormField label="Contenido" required error={errors.content?.[0]} fullWidth>
        <FormTextarea
          name="content"
          value={formData.content}
          onChange={handleInputChange}
          placeholder="Escribe el contenido de la noticia"
          rows={8}
          required
        />
      </FormField>

      {/* Author and Date Row */}
      <div style={{ display: 'contents' }}>
        <FormField label="Autor" required error={errors.author?.[0]}>
          <FormInput
            name="author"
            value={formData.author}
            onChange={handleInputChange}
            placeholder="Nombre del autor"
            required
          />
        </FormField>

        <FormField label="Fecha de Publicación" required error={errors.published_at?.[0]}>
          <FormInput
            type="datetime-local"
            name="published_at"
            value={formData.published_at}
            onChange={handleInputChange}
            required
          />
        </FormField>
      </div>

      {/* Type and Status Row */}
      <div style={{ display: 'contents' }}>
        <FormField label="Tipo" required error={errors.type?.[0]}>
          <FormSelect
            name="type"
            value={formData.type}
            onChange={handleInputChange}
            required
          >
            <option value="local">Local</option>
            <option value="internacional">Internacional</option>
          </FormSelect>
        </FormField>

        <FormField label="Estado" required error={errors.status?.[0]}>
          <FormSelect
            name="status"
            value={formData.status}
            onChange={handleInputChange}
            required
          >
            <option value="draft">Borrador</option>
            <option value="published">Publicado</option>
          </FormSelect>
        </FormField>
      </div>

      {/* Image Upload */}
      <FormField 
        label="Imagen" 
        error={errors.image?.[0]} 
        fullWidth
        description="Formatos soportados: JPG, PNG, GIF. Tamaño máximo: 2MB"
      >
        {imagePreview && (
          <div style={{ marginBottom: '1rem' }}>
            <img 
              src={imagePreview} 
              alt="Preview" 
              style={{ 
                maxWidth: '200px', 
                maxHeight: '150px', 
                borderRadius: '6px',
                objectFit: 'cover',
                border: '2px solid #374151'
              }} 
            />
            <button
              type="button"
              onClick={handleRemoveImage}
              style={{
                backgroundColor: '#ef4444',
                color: 'white',
                border: 'none',
                borderRadius: '6px',
                padding: '0.5rem 1rem',
                cursor: 'pointer',
                fontSize: '0.8rem',
                marginLeft: '1rem',
                display: 'flex',
                alignItems: 'center',
                gap: '0.25rem'
              }}
            >
              <i className="fas fa-trash"></i>
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
      </FormField>
    </ResponsiveForm>
  );
}