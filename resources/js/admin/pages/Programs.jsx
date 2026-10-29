import React, { useState } from 'react';
import Layout from '../components/Layout';
import ProgramsList from './Programs/ProgramsList';
import ProgramForm from './Programs/ProgramForm';
import PodcastManager from './Programs/PodcastManager';
import Notification from '../components/Notification';
import { useNotification } from '../hooks/useNotification';

export default function Programs() {
  const [currentView, setCurrentView] = useState('list'); // 'list', 'create', 'edit', 'podcasts'
  const [selectedProgram, setSelectedProgram] = useState(null);
  const { notifications, showSuccess, showError, removeNotification } = useNotification();

  const handleCreate = () => {
    setSelectedProgram(null);
    setCurrentView('create');
  };

  const handleEdit = (program) => {
    setSelectedProgram(program);
    setCurrentView('edit');
  };

  const handleManagePodcasts = (program) => {
    setSelectedProgram(program);
    setCurrentView('podcasts');
  };

  const handleSave = (savedProgram) => {
    // Show success message
    showSuccess(`Programa ${currentView === 'create' ? 'creado' : 'actualizado'} correctamente`);
    
    // Return to list view
    setCurrentView('list');
    setSelectedProgram(null);
  };

  const handleCancel = () => {
    setCurrentView('list');
    setSelectedProgram(null);
  };

  const handlePodcastNotification = (message, type) => {
    if (type === 'success') {
      showSuccess(message);
    } else if (type === 'error') {
      showError(message);
    }
  };

  return (
    <Layout 
      title="🎙️ Programas" 
      subtitle="Gestión de programas de Radio Stereo Umachiri"
      color="#2563eb"
    >
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: '2rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
      }}>
        {currentView === 'list' && (
          <ProgramsList 
            onEdit={handleEdit}
            onCreate={handleCreate}
            onManagePodcasts={handleManagePodcasts}
          />
        )}
        
        {(currentView === 'create' || currentView === 'edit') && (
          <ProgramForm
            program={selectedProgram}
            onSave={handleSave}
            onCancel={handleCancel}
          />
        )}

        {currentView === 'podcasts' && selectedProgram && (
          <PodcastManager
            program={selectedProgram}
            onClose={handleCancel}
            onNotification={handlePodcastNotification}
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
