import React, { useState, useEffect } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';

export default function ResponsiveSidebar() {
  const location = useLocation();
  const navigate = useNavigate();
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      const mobile = window.innerWidth <= 768;
      setIsMobile(mobile);
      if (!mobile) {
        setIsMobileMenuOpen(false);
      }
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const toggleMobileMenu = () => {
    setIsMobileMenuOpen(!isMobileMenuOpen);
  };

  const handleNavClick = (path) => {
    navigate(path);
    if (isMobile) {
      setIsMobileMenuOpen(false);
    }
  };

  const navItems = [
    { path: '/dashboard', icon: 'fas fa-tachometer-alt', label: 'Dashboard' },
    { path: '/news', icon: 'fas fa-newspaper', label: 'Noticias' },
    { path: '/sports', icon: 'fas fa-futbol', label: 'Deportes' },
    { path: '/programs', icon: 'fas fa-broadcast-tower', label: 'Programas' },
    { path: '/djs', icon: 'fas fa-microphone', label: 'DJs' },
    { path: '/events', icon: 'fas fa-calendar-alt', label: 'Eventos' },
    { path: '/galleries', icon: 'fas fa-images', label: 'Galerías' },
    { path: '/comments', icon: 'fas fa-comments', label: 'Comentarios' },
    { path: '/users', icon: 'fas fa-users', label: 'Usuarios' },
    { path: '/messages', icon: 'fas fa-envelope', label: 'Mensajes' },
    { path: '/analytics', icon: 'fas fa-chart-line', label: 'Analytics' }
  ];

  const sidebarStyles = {
    sidebar: {
      width: isMobile ? '280px' : '260px',
      backgroundColor: '#1e293b',
      color: '#cbd5e1',
      display: 'flex',
      flexDirection: 'column',
      height: '100vh',
      position: 'fixed',
      top: 0,
      left: 0,
      padding: '2rem 1.5rem',
      boxShadow: '2px 0 8px rgba(0,0,0,0.7)',
      zIndex: 1000,
      transition: 'transform 0.3s ease',
      transform: isMobile && !isMobileMenuOpen ? 'translateX(-100%)' : 'translateX(0)'
    },
    mobileHeader: {
      display: isMobile ? 'flex' : 'none',
      backgroundColor: '#1e293b',
      color: '#cbd5e1',
      padding: '1rem',
      position: 'fixed',
      top: 0,
      left: 0,
      right: 0,
      zIndex: 998,
      boxShadow: '0 2px 8px rgba(0,0,0,0.7)',
      justifyContent: 'space-between',
      alignItems: 'center'
    },
    hamburgerBtn: {
      background: 'none',
      border: 'none',
      color: '#cbd5e1',
      fontSize: '1.5rem',
      cursor: 'pointer',
      padding: '0.5rem',
      borderRadius: '4px',
      transition: 'background-color 0.2s'
    },
    overlay: {
      display: isMobile && isMobileMenuOpen ? 'block' : 'none',
      position: 'fixed',
      top: 0,
      left: 0,
      right: 0,
      bottom: 0,
      backgroundColor: 'rgba(0, 0, 0, 0.5)',
      zIndex: 999
    },
    navItem: {
      display: 'flex',
      alignItems: 'center',
      padding: isMobile ? '1rem' : '1rem 1.5rem',
      color: '#cbd5e1',
      textDecoration: 'none',
      fontWeight: '600',
      fontSize: isMobile ? '1.1rem' : '1rem',
      borderLeft: '4px solid transparent',
      transition: 'all 0.3s ease',
      cursor: 'pointer',
      marginBottom: '0.25rem',
      borderRadius: '6px'
    },
    navItemActive: {
      color: 'white',
      backgroundColor: '#2563eb',
      borderLeftColor: '#3b82f6'
    },
    navIcon: {
      marginRight: '1rem',
      fontSize: isMobile ? '1.3rem' : '1.2rem',
      width: '24px',
      textAlign: 'center'
    }
  };

  return (
    <>
      {/* Mobile Header */}
      <header style={sidebarStyles.mobileHeader}>
        <button
          style={sidebarStyles.hamburgerBtn}
          onClick={toggleMobileMenu}
          onMouseEnter={(e) => e.target.style.backgroundColor = '#374151'}
          onMouseLeave={(e) => e.target.style.backgroundColor = 'transparent'}
        >
          <i className="fas fa-bars"></i>
        </button>
        <h3 style={{ margin: 0, fontSize: '1.2rem' }}>Admin Panel</h3>
        <div style={{ width: '40px' }}></div>
      </header>

      {/* Mobile Overlay */}
      <div
        style={sidebarStyles.overlay}
        onClick={() => setIsMobileMenuOpen(false)}
      ></div>

      {/* Sidebar */}
      <nav style={sidebarStyles.sidebar}>
        <div>
          <h3 style={{ 
            fontWeight: '700', 
            fontSize: '1.5rem', 
            letterSpacing: '1px', 
            marginBottom: '2rem', 
            textAlign: 'center' 
          }}>
            Admin Panel
          </h3>
          <div style={{ 
            fontSize: '0.8rem', 
            color: '#94a3b8', 
            textAlign: 'center', 
            marginBottom: '1rem',
            padding: '0.5rem',
            backgroundColor: '#374151',
            borderRadius: '6px'
          }}>
            <div>👋 Bienvenido</div>
            <div>Radio Stereo Umachiri</div>
          </div>
        </div>

        <div>
          {navItems.map(item => {
            const isActive = location.pathname === item.path;
            return (
              <div
                key={item.path}
                style={{
                  ...sidebarStyles.navItem,
                  ...(isActive ? sidebarStyles.navItemActive : {})
                }}
                onClick={() => handleNavClick(item.path)}
                onMouseEnter={(e) => {
                  if (!isActive) {
                    e.target.style.color = 'white';
                    e.target.style.backgroundColor = '#374151';
                  }
                }}
                onMouseLeave={(e) => {
                  if (!isActive) {
                    e.target.style.color = '#cbd5e1';
                    e.target.style.backgroundColor = 'transparent';
                  }
                }}
              >
                <i className={item.icon} style={sidebarStyles.navIcon}></i>
                <span>{item.label}</span>
              </div>
            );
          })}
        </div>

        <div style={{ marginTop: 'auto', paddingTop: '2rem' }}>
          <form
            method="POST"
            action="/logout"
            style={{ margin: 0 }}
          >
            <input
              type="hidden"
              name="_token"
              value={document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')}
            />
            <button
              type="submit"
              style={{
                ...sidebarStyles.navItem,
                width: '100%',
                border: 'none',
                background: 'transparent',
                textAlign: 'left',
                color: '#ef4444'
              }}
              onMouseEnter={(e) => {
                e.target.style.backgroundColor = '#374151';
              }}
              onMouseLeave={(e) => {
                e.target.style.backgroundColor = 'transparent';
              }}
            >
              <i className="fas fa-sign-out-alt" style={sidebarStyles.navIcon}></i>
              <span>Cerrar Sesión</span>
            </button>
          </form>
        </div>
      </nav>
    </>
  );
}