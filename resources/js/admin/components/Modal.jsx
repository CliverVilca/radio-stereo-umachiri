import React from 'react';

export default function Modal({ 
  isOpen, 
  onClose, 
  title, 
  children, 
  size = 'medium',
  showCloseButton = true 
}) {
  if (!isOpen) return null;

  const sizeClasses = {
    small: { maxWidth: '400px' },
    medium: { maxWidth: '600px' },
    large: { maxWidth: '800px' },
    xlarge: { maxWidth: '1200px' }
  };

  const handleBackdropClick = (e) => {
    if (e.target === e.currentTarget) {
      onClose();
    }
  };

  return (
    <div 
      style={{
        position: 'fixed',
        top: 0,
        left: 0,
        right: 0,
        bottom: 0,
        backgroundColor: 'rgba(0, 0, 0, 0.75)',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        zIndex: 1000,
        padding: '1rem'
      }}
      onClick={handleBackdropClick}
    >
      <div 
        style={{
          backgroundColor: '#1f2937',
          borderRadius: '12px',
          boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
          width: '100%',
          ...sizeClasses[size],
          maxHeight: '90vh',
          overflow: 'hidden',
          display: 'flex',
          flexDirection: 'column'
        }}
        onClick={(e) => e.stopPropagation()}
      >
        {/* Header */}
        {(title || showCloseButton) && (
          <div style={{
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'space-between',
            padding: '1.5rem 2rem',
            borderBottom: '1px solid #374151'
          }}>
            {title && (
              <h3 style={{
                margin: 0,
                fontSize: '1.25rem',
                fontWeight: '600',
                color: '#e5e7eb'
              }}>
                {title}
              </h3>
            )}
            {showCloseButton && (
              <button
                onClick={onClose}
                style={{
                  backgroundColor: 'transparent',
                  border: 'none',
                  color: '#9ca3af',
                  cursor: 'pointer',
                  fontSize: '1.5rem',
                  padding: '0.25rem',
                  borderRadius: '4px',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  width: '2rem',
                  height: '2rem'
                }}
                onMouseEnter={(e) => {
                  e.target.style.backgroundColor = '#374151';
                  e.target.style.color = '#e5e7eb';
                }}
                onMouseLeave={(e) => {
                  e.target.style.backgroundColor = 'transparent';
                  e.target.style.color = '#9ca3af';
                }}
              >
                <i className="fas fa-times"></i>
              </button>
            )}
          </div>
        )}

        {/* Content */}
        <div style={{
          padding: '2rem',
          overflowY: 'auto',
          flex: 1
        }}>
          {children}
        </div>
      </div>
    </div>
  );
}