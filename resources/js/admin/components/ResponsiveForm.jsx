import React, { useState, useEffect } from 'react';

export default function ResponsiveForm({ 
  title,
  onSubmit,
  onCancel,
  loading = false,
  children,
  submitText = "Guardar",
  cancelText = "Cancelar"
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const formStyles = {
    container: {
      backgroundColor: '#1f2937',
      borderRadius: '12px',
      padding: isMobile ? '1rem' : '2rem',
      boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
      maxWidth: isMobile ? '100%' : '800px',
      margin: '0 auto'
    },
    header: {
      marginBottom: isMobile ? '1.5rem' : '2rem',
      paddingBottom: '1rem',
      borderBottom: '1px solid #374151'
    },
    title: {
      color: '#3b82f6',
      fontSize: isMobile ? '1.5rem' : '1.8rem',
      fontWeight: '700',
      margin: 0
    },
    form: {
      display: 'flex',
      flexDirection: 'column',
      gap: isMobile ? '1rem' : '1.5rem'
    },
    fieldGroup: {
      display: 'grid',
      gridTemplateColumns: isMobile ? '1fr' : 'repeat(auto-fit, minmax(250px, 1fr))',
      gap: isMobile ? '1rem' : '1.5rem'
    },
    fullWidth: {
      gridColumn: '1 / -1'
    },
    buttonGroup: {
      display: 'flex',
      flexDirection: isMobile ? 'column' : 'row',
      gap: '1rem',
      justifyContent: 'flex-end',
      marginTop: '2rem',
      paddingTop: '1rem',
      borderTop: '1px solid #374151'
    },
    button: {
      padding: isMobile ? '1rem' : '0.75rem 2rem',
      borderRadius: '8px',
      fontSize: isMobile ? '1rem' : '0.9rem',
      fontWeight: '600',
      cursor: 'pointer',
      border: 'none',
      transition: 'all 0.2s',
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'center',
      gap: '0.5rem',
      minHeight: isMobile ? '48px' : 'auto'
    },
    submitButton: {
      backgroundColor: loading ? '#6b7280' : '#2563eb',
      color: 'white'
    },
    cancelButton: {
      backgroundColor: '#6b7280',
      color: 'white'
    }
  };

  return (
    <div style={formStyles.container}>
      {title && (
        <div style={formStyles.header}>
          <h2 style={formStyles.title}>{title}</h2>
        </div>
      )}
      
      <form onSubmit={onSubmit} style={formStyles.form}>
        {children}
        
        <div style={formStyles.buttonGroup}>
          <button
            type="button"
            onClick={onCancel}
            disabled={loading}
            style={{
              ...formStyles.button,
              ...formStyles.cancelButton,
              opacity: loading ? 0.6 : 1,
              cursor: loading ? 'not-allowed' : 'pointer'
            }}
          >
            <i className="fas fa-times"></i>
            {cancelText}
          </button>
          
          <button
            type="submit"
            disabled={loading}
            style={{
              ...formStyles.button,
              ...formStyles.submitButton,
              opacity: loading ? 0.8 : 1,
              cursor: loading ? 'not-allowed' : 'pointer'
            }}
          >
            {loading ? (
              <>
                <i className="fas fa-spinner fa-spin"></i>
                Guardando...
              </>
            ) : (
              <>
                <i className="fas fa-save"></i>
                {submitText}
              </>
            )}
          </button>
        </div>
      </form>
    </div>
  );
}

// Field components for consistent styling
export function FormField({ 
  label, 
  children, 
  error, 
  required = false, 
  fullWidth = false,
  description 
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const fieldStyles = {
    container: {
      display: 'flex',
      flexDirection: 'column',
      gap: '0.5rem',
      gridColumn: fullWidth ? '1 / -1' : 'auto'
    },
    label: {
      color: '#e5e7eb',
      fontSize: isMobile ? '1rem' : '0.9rem',
      fontWeight: '600',
      display: 'flex',
      alignItems: 'center',
      gap: '0.25rem'
    },
    required: {
      color: '#ef4444',
      fontSize: '0.8rem'
    },
    description: {
      color: '#9ca3af',
      fontSize: '0.8rem',
      marginTop: '0.25rem'
    },
    error: {
      color: '#ef4444',
      fontSize: '0.8rem',
      marginTop: '0.25rem',
      display: 'flex',
      alignItems: 'center',
      gap: '0.25rem'
    }
  };

  return (
    <div style={fieldStyles.container}>
      {label && (
        <label style={fieldStyles.label}>
          {label}
          {required && <span style={fieldStyles.required}>*</span>}
        </label>
      )}
      {children}
      {description && (
        <div style={fieldStyles.description}>{description}</div>
      )}
      {error && (
        <div style={fieldStyles.error}>
          <i className="fas fa-exclamation-triangle"></i>
          {error}
        </div>
      )}
    </div>
  );
}

export function FormInput({ 
  type = 'text', 
  value, 
  onChange, 
  placeholder, 
  disabled = false,
  ...props 
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const inputStyles = {
    backgroundColor: '#374151',
    border: '1px solid #4b5563',
    borderRadius: '6px',
    padding: isMobile ? '1rem' : '0.75rem',
    color: '#e5e7eb',
    fontSize: isMobile ? '1rem' : '0.9rem',
    width: '100%',
    transition: 'border-color 0.2s',
    minHeight: isMobile ? '48px' : 'auto'
  };

  return (
    <input
      type={type}
      value={value}
      onChange={onChange}
      placeholder={placeholder}
      disabled={disabled}
      style={{
        ...inputStyles,
        opacity: disabled ? 0.6 : 1,
        cursor: disabled ? 'not-allowed' : 'text'
      }}
      onFocus={(e) => e.target.style.borderColor = '#3b82f6'}
      onBlur={(e) => e.target.style.borderColor = '#4b5563'}
      {...props}
    />
  );
}

export function FormTextarea({ 
  value, 
  onChange, 
  placeholder, 
  rows = 4,
  disabled = false,
  ...props 
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const textareaStyles = {
    backgroundColor: '#374151',
    border: '1px solid #4b5563',
    borderRadius: '6px',
    padding: isMobile ? '1rem' : '0.75rem',
    color: '#e5e7eb',
    fontSize: isMobile ? '1rem' : '0.9rem',
    width: '100%',
    resize: 'vertical',
    minHeight: isMobile ? '120px' : '100px',
    transition: 'border-color 0.2s'
  };

  return (
    <textarea
      value={value}
      onChange={onChange}
      placeholder={placeholder}
      rows={rows}
      disabled={disabled}
      style={{
        ...textareaStyles,
        opacity: disabled ? 0.6 : 1,
        cursor: disabled ? 'not-allowed' : 'text'
      }}
      onFocus={(e) => e.target.style.borderColor = '#3b82f6'}
      onBlur={(e) => e.target.style.borderColor = '#4b5563'}
      {...props}
    />
  );
}

export function FormSelect({ 
  value, 
  onChange, 
  children, 
  disabled = false,
  ...props 
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const selectStyles = {
    backgroundColor: '#374151',
    border: '1px solid #4b5563',
    borderRadius: '6px',
    padding: isMobile ? '1rem' : '0.75rem',
    color: '#e5e7eb',
    fontSize: isMobile ? '1rem' : '0.9rem',
    width: '100%',
    minHeight: isMobile ? '48px' : 'auto',
    transition: 'border-color 0.2s'
  };

  return (
    <select
      value={value}
      onChange={onChange}
      disabled={disabled}
      style={{
        ...selectStyles,
        opacity: disabled ? 0.6 : 1,
        cursor: disabled ? 'not-allowed' : 'pointer'
      }}
      onFocus={(e) => e.target.style.borderColor = '#3b82f6'}
      onBlur={(e) => e.target.style.borderColor = '#4b5563'}
      {...props}
    >
      {children}
    </select>
  );
}