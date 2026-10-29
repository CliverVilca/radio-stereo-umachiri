import React from 'react';
import Layout from '../components/Layout';
import CommentsList from './Comments/CommentsList';
import Notification from '../components/Notification';
import { useNotification } from '../hooks/useNotification';

export default function Comments() {
  const { notifications, showSuccess, showError, showWarning, removeNotification } = useNotification();

  const handleNotification = (message, type) => {
    switch (type) {
      case 'success':
        showSuccess(message);
        break;
      case 'error':
        showError(message);
        break;
      case 'warning':
        showWarning(message);
        break;
      default:
        showSuccess(message);
    }
  };

  return (
    <Layout 
      title="💬 Comentarios" 
      subtitle="Gestión de comentarios de Radio Stereo Umachiri"
      color="#16a34a"
    >
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: '2rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
      }}>
        <CommentsList onNotification={handleNotification} />
      </div>

      {/* Notifications */}
      {notifications.map(notification => (
        <Notification
          key={notification.id}
          message={notification.message}
          type={notification.type}
          duration={notification.duration}
          onClose={() => removeNotification(notification.id)}
        />
      ))}
    </Layout>
  );
}
