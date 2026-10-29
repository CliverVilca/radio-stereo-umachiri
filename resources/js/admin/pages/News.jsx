import React, { useState } from 'react';
import Layout from '../components/Layout';
import NewsList from './News/NewsList';
import NewsForm from './News/NewsForm';
import Notification from '../components/Notification';
import { useNotification } from '../hooks/useNotification';

export default function News() {
  const [currentView, setCurrentView] = useState('list'); // 'list', 'create', 'edit'
  const [selectedNews, setSelectedNews] = useState(null);
  const { notifications, showSuccess, showError, removeNotification } = useNotification();

  const handleCreate = () => {
    setSelectedNews(null);
    setCurrentView('create');
  };

  const handleEdit = (news) => {
    setSelectedNews(news);
    setCurrentView('edit');
  };

  const handleSave = (savedNews) => {
    // Show success message
    showSuccess(`Noticia ${currentView === 'create' ? 'creada' : 'actualizada'} correctamente`);
    
    // Return to list view
    setCurrentView('list');
    setSelectedNews(null);
  };

  const handleCancel = () => {
    setCurrentView('list');
    setSelectedNews(null);
  };

  return (
    <Layout 
      title="📰 Noticias" 
      subtitle="Gestión de noticias de Radio Stereo Umachiri"
      color="#ef4444"
    >
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: '2rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
      }}>
        {currentView === 'list' && (
          <NewsList 
            onEdit={handleEdit}
            onCreate={handleCreate}
          />
        )}
        
        {(currentView === 'create' || currentView === 'edit') && (
          <NewsForm
            news={selectedNews}
            onSave={handleSave}
            onCancel={handleCancel}
          />
        )}
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
