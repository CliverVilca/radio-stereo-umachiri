// Format date for display
export const formatDate = (date) => {
  if (!date) return '';
  
  const d = new Date(date);
  return d.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

// Format file size
export const formatFileSize = (bytes) => {
  if (bytes === 0) return '0 Bytes';
  
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
};

// Validate file type
export const validateFileType = (file, allowedTypes) => {
  return allowedTypes.includes(file.type);
};

// Validate file size
export const validateFileSize = (file, maxSize) => {
  return file.size <= maxSize;
};

// Truncate text
export const truncateText = (text, maxLength = 100) => {
  if (!text) return '';
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + '...';
};

// Capitalize first letter
export const capitalize = (str) => {
  if (!str) return '';
  return str.charAt(0).toUpperCase() + str.slice(1);
};

// Generate slug from title
export const generateSlug = (title) => {
  if (!title) return '';
  
  return title
    .toLowerCase()
    .replace(/[^\w\s-]/g, '') // Remove special characters
    .replace(/\s+/g, '-') // Replace spaces with hyphens
    .replace(/-+/g, '-') // Replace multiple hyphens with single
    .trim();
};

// Debounce function
export const debounce = (func, wait) => {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
};

// Get status color
export const getStatusColor = (status) => {
  const colors = {
    draft: '#6b7280',
    published: '#16a34a',
    pending: '#f59e0b',
    approved: '#16a34a',
    rejected: '#ef4444',
    active: '#16a34a',
    inactive: '#6b7280'
  };
  
  return colors[status] || '#6b7280';
};

// Get status label
export const getStatusLabel = (status) => {
  const labels = {
    draft: 'Borrador',
    published: 'Publicado',
    pending: 'Pendiente',
    approved: 'Aprobado',
    rejected: 'Rechazado',
    active: 'Activo',
    inactive: 'Inactivo'
  };
  
  return labels[status] || status;
};

// Handle API errors
export const handleApiError = (error) => {
  if (error.response) {
    // Server responded with error status
    const { status, data } = error.response;
    
    if (status === 422) {
      // Validation errors
      return {
        message: 'Error de validación',
        errors: data.errors || {}
      };
    } else if (status === 401) {
      return {
        message: 'No autorizado. Por favor, inicia sesión nuevamente.',
        errors: {}
      };
    } else if (status === 403) {
      return {
        message: 'No tienes permisos para realizar esta acción.',
        errors: {}
      };
    } else if (status === 404) {
      return {
        message: 'Recurso no encontrado.',
        errors: {}
      };
    } else if (status >= 500) {
      return {
        message: 'Error del servidor. Por favor, intenta más tarde.',
        errors: {}
      };
    }
    
    return {
      message: data.message || 'Error desconocido',
      errors: data.errors || {}
    };
  } else if (error.request) {
    // Network error
    return {
      message: 'Error de conexión. Verifica tu conexión a internet.',
      errors: {}
    };
  } else {
    // Other error
    return {
      message: error.message || 'Error desconocido',
      errors: {}
    };
  }
};

export default {
  formatDate,
  formatFileSize,
  validateFileType,
  validateFileSize,
  truncateText,
  capitalize,
  generateSlug,
  debounce,
  getStatusColor,
  getStatusLabel,
  handleApiError
};