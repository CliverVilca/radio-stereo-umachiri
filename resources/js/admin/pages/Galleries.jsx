import React, { useState } from 'react';
import Layout from '../components/Layout';
import GalleriesList from './Galleries/GalleriesList';
import GalleryForm from './Galleries/GalleryForm';
import Notification from '../components/Notification';
import { useNotification } from '../hooks/useNotification';

export default function Galleries() {
  const [currentView, setCurrentView] = useState('list'); // 'list', 'create', 'edit'
  const [selectedGallery, setSelectedGallery] = useState(null);
  const { notifications, showSuccess, showError, removeNotification } = useNotification();

  const handleCreate = () => {
    setSelectedGallery(null);
    setCurrentView('create');
  };

  const handleEdit = (gallery) => {
    setSelectedGallery(gallery);
    setCurrentView('edit');
  };

  const handleSave = (savedGallery) => {
    // Show success message
    showSuccess(`Galería ${currentView === 'create' ? 'creada' : 'actualizada'} correctamente`);
    
    // Return to list view
    setCurrentView('list');
    setSelectedGallery(null);
  };

  const handleCancel = () => {
    setCurrentView('list');
    setSelectedGallery(null);
  };

  return (
    <Layout 
      title="🖼️ Galerías" 
      subtitle="Gestión de galerías de Radio Stereo Umachiri"
      color="#f59e0b"
    >
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: '2rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
      }}>
        {currentView === 'list' && (
          <GalleriesList 
            onEdit={handleEdit}
            onCreate={handleCreate}
          />
        )}
        
        {(currentView === 'create' || currentView === 'edit') && (
          <GalleryForm
            gallery={selectedGallery}
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