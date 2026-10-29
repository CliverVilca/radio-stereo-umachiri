import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import ResponsiveSidebar from './components/ResponsiveSidebar';
import Dashboard from './pages/Dashboard';
import Programs from './pages/Programs';
import News from './pages/News';
import Comments from './pages/Comments';
import Events from './pages/Events';
import Galleries from './pages/Galleries';
import Sports from './pages/Sports';
import DJs from './pages/DJs';
// import Users from './pages/Users';
// import Messages from './pages/Messages';
import Analytics from './pages/Analytics';

export default function App() {
  console.log('Admin App is loading...');
  
  const [screenSize, setScreenSize] = useState({
    width: window.innerWidth,
    height: window.innerHeight
  });

  useEffect(() => {
    const handleResize = () => {
      setScreenSize({
        width: window.innerWidth,
        height: window.innerHeight
      });
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  // Responsive breakpoints
  const isMobile = screenSize.width <= 768;
  const isTablet = screenSize.width > 768 && screenSize.width <= 1024;
  const isDesktop = screenSize.width > 1024;
  const isLargeScreen = screenSize.width > 1440;

  // Dynamic padding and spacing based on screen size
  const getResponsivePadding = () => {
    if (isMobile) return '1rem';
    if (isTablet) return '1.5rem 2rem';
    if (isLargeScreen) return '2rem 4rem';
    return '2rem 3rem';
  };

  const getSidebarWidth = () => {
    if (isMobile) return '0';
    if (isTablet) return '240px';
    return '260px';
  };

  const mainContentStyles = {
    flexGrow: 1,
    padding: getResponsivePadding(),
    backgroundColor: '#121212',
    color: '#e0e7ff',
    marginLeft: getSidebarWidth(),
    paddingTop: isMobile ? '5rem' : '2rem',
    minHeight: '100vh',
    transition: 'all 0.3s ease',
    maxWidth: '100%',
    overflow: 'hidden'
  };
  
  return (
    <Router basename="/admin">
      <div style={{ display: 'flex', minHeight: '100vh', position: 'relative' }}>
        <ResponsiveSidebar />
        <main style={mainContentStyles}>
          <Routes>
            <Route path="/" element={<Navigate to="/dashboard" replace />} />
            <Route path="/dashboard" element={<Dashboard />} />
            <Route path="/programs" element={<Programs />} />
            <Route path="/news" element={<News />} />
            <Route path="/comments" element={<Comments />} />
            <Route path="/events" element={<Events />} />
            <Route path="/galleries" element={<Galleries />} />
            <Route path="/sports" element={<Sports />} />
            <Route path="/djs" element={<DJs />} />
            {/* Placeholder routes for new sections */}
            <Route path="/users" element={<div><h1>👥 Usuarios</h1><p>En desarrollo...</p></div>} />
            <Route path="/messages" element={<div><h1>📧 Mensajes</h1><p>En desarrollo...</p></div>} />
            <Route path="/analytics" element={<Analytics />} />
          </Routes>
        </main>
      </div>
    </Router>
  );
}
