import React, { useState, useEffect } from 'react';

export default function Notification({ 
  message, 
  type = 'success', 
  duration = 5000, 
  onClose 
}) {
  const [isVisible, setIsVisible] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsVisible(false);
      setTimeout(() => onClose && onClose(), 300); // Wait for animation
    }, duration);

    return () => clearTimeout(timer);
  }, [duration, onClose]);

  const typeStyles = {
    success: {
      backgroundColor: '#16a34a',
      icon: 'fas fa-check-circle'
    },
    error: {
      backgroundColor: '#ef4444',
      icon: 'fas fa-exclamation-circle'
    },
    warning: {
      backgroundColor: '#f59e0b',
      icon: 'fas fa-exclamation-triangle'
    },
    info: {
      backgroundColor: '#2563eb',
      icon: 'fas fa-info-circle'
    }
  };

  const currentStyle = typeStyles[type];

  const handleClose = () => {
    setIsVisible(false);
    setTimeout(() => onClose && onClose(), 300);
  };

  return (
    <div
      style={{
        position: 'fixed',
        top: '2rem',
        right: '2rem',
        backgroundColor: currentStyle.backgroundColor,
        color: 'white',
        borderRadius: '8px',
        padding: '1rem 1.5rem',
        boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        zIndex: 1000,
        display: 'flex',
        alignItems: 'center',
        gap: '0.75rem',
        minWidth: '300px',
        maxWidth: '500px',
        transform: isVisible ? 'translateX(0)' : 'translateX(100%)',
        opacity: isVisible ? 1 : 0,
        transition: 'all 0.3s ease-in-out'
      }}
    >
      <i className={currentStyle.icon} style={{ fontSize: '1.25rem' }}></i>
      <span style={{ flex: 1, fontSize: '0.9rem', fontWeight: '500' }}>
        {message}
      </span>
      <button
        onClick={handleClose}
        style={{
          backgroundColor: 'transparent',
          border: 'none',
          color: 'white',
          cursor: 'pointer',
          fontSize: '1rem',
          padding: '0.25rem',
          borderRadius: '4px',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          opacity: 0.8
        }}
        onMouseEnter={(e) => e.target.style.opacity = '1'}
        onMouseLeave={(e) => e.target.style.opacity = '0.8'}
      >
        <i className="fas fa-times"></i>
      </button>
    </div>
  );
}