import React, { useState } from 'react';
import DJsList from './DJs/DJsList';
import DJsForm from './DJs/DJsForm';
import { useNotification } from '../hooks/useNotification';

export default function DJs() {
  const [currentView, setCurrentView] = useState('list');
  const [editingDJ, setEditingDJ] = useState(null);
  const { showNotification } = useNotification();

  const handleCreate = () => {
    setEditingDJ(null);
    setCurrentView('form');
  };

  const handleEdit = (dj) => {
    setEditingDJ(dj);
    setCurrentView('form');
  };

  const handleFormSave = (dj) => {
    showNotification(
      editingDJ ? 'DJ actualizado correctamente' : 'DJ creado correctamente',
      'success'
    );
    setCurrentView('list');
    setEditingDJ(null);
  };

  const handleFormCancel = () => {
    setCurrentView('list');
    setEditingDJ(null);
  };

  return (
    <div style={{ 
      minHeight: '100vh',
      backgroundColor: '#0f172a',
      color: '#e2e8f0'
    }}>
      {currentView === 'list' && (
        <DJsList 
          onEdit={handleEdit}
          onCreate={handleCreate}
        />
      )}
      
      {currentView === 'form' && (
        <DJsForm
          dj={editingDJ}
          onSave={handleFormSave}
          onCancel={handleFormCancel}
        />
      )}
    </div>
  );
}