import React from 'react';
import Modal from './Modal';

export default function ConfirmDialog({
  isOpen,
  onClose,
  onConfirm,
  title = 'Confirmar acción',
  message = '¿Estás seguro de que quieres continuar?',
  confirmText = 'Confirmar',
  cancelText = 'Cancelar',
  type = 'danger' // 'danger', 'warning', 'info'
}) {
  const typeStyles = {
    danger: {
      confirmBg: '#ef4444',
      icon: 'fas fa-exclamation-triangle',
      iconColor: '#ef4444'
    },
    warning: {
      confirmBg: '#f59e0b',
      icon: 'fas fa-exclamation-circle',
      iconColor: '#f59e0b'
    },
    info: {
      confirmBg: '#2563eb',
      icon: 'fas fa-info-circle',
      iconColor: '#2563eb'
    }
  };

  const currentStyle = typeStyles[type];

  const handleConfirm = () => {
    onConfirm();
    onClose();
  };

  return (
    <Modal
      isOpen={isOpen}
      onClose={onClose}
      size="small"
      showCloseButton={false}
    >
      <div style={{ textAlign: 'center' }}>
        {/* Icon */}
        <div style={{
          backgroundColor: `${currentStyle.iconColor}20`,
          borderRadius: '50%',
          width: '4rem',
          height: '4rem',
          display: 'flex',
          alignItems: 'center',
          justifyContent: 'center',
          margin: '0 auto 1.5rem'
        }}>
          <i 
            className={currentStyle.icon}
            style={{
              fontSize: '1.5rem',
              color: currentStyle.iconColor
            }}
          ></i>
        </div>

        {/* Title */}
        <h3 style={{
          margin: '0 0 1rem',
          fontSize: '1.25rem',
          fontWeight: '600',
          color: '#e5e7eb'
        }}>
          {title}
        </h3>

        {/* Message */}
        <p style={{
          margin: '0 0 2rem',
          color: '#9ca3af',
          lineHeight: '1.5'
        }}>
          {message}
        </p>

        {/* Buttons */}
        <div style={{
          display: 'flex',
          gap: '1rem',
          justifyContent: 'center'
        }}>
          <button
            onClick={onClose}
            style={{
              backgroundColor: '#6b7280',
              color: 'white',
              border: 'none',
              borderRadius: '6px',
              padding: '0.75rem 1.5rem',
              cursor: 'pointer',
              fontSize: '0.9rem',
              fontWeight: '600',
              minWidth: '100px'
            }}
          >
            {cancelText}
          </button>
          <button
            onClick={handleConfirm}
            style={{
              backgroundColor: currentStyle.confirmBg,
              color: 'white',
              border: 'none',
              borderRadius: '6px',
              padding: '0.75rem 1.5rem',
              cursor: 'pointer',
              fontSize: '0.9rem',
              fontWeight: '600',
              minWidth: '100px'
            }}
          >
            {confirmText}
          </button>
        </div>
      </div>
    </Modal>
  );
}