import React, { useState, useEffect } from 'react';

export default function Layout({ 
  title, 
  subtitle, 
  color = '#3b82f6', 
  children,
  actions = null
}) {
  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };

    window.addEventListener('resize', handleResize);
    return () => window.removeEventListener('resize', handleResize);
  }, []);

  const layoutStyles = {
    container: {
      width: '100%',
      maxWidth: '100%'
    },
    header: {
      marginBottom: isMobile ? '1.5rem' : '2rem',
      display: 'flex',
      flexDirection: isMobile ? 'column' : 'row',
      justifyContent: 'space-between',
      alignItems: isMobile ? 'flex-start' : 'center',
      gap: isMobile ? '1rem' : '0'
    },
    titleSection: {
      flex: 1
    },
    title: {
      fontSize: isMobile ? '1.75rem' : '2rem',
      fontWeight: '700',
      color: color,
      margin: 0,
      marginBottom: subtitle ? '0.5rem' : 0
    },
    subtitle: {
      fontSize: isMobile ? '1rem' : '1.1rem',
      color: '#94a3b8',
      margin: 0
    },
    actions: {
      display: 'flex',
      gap: '0.75rem',
      flexWrap: 'wrap'
    },
    content: {
      width: '100%'
    }
  };

  return (
    <div style={layoutStyles.container}>
      {(title || subtitle || actions) && (
        <div style={layoutStyles.header}>
          <div style={layoutStyles.titleSection}>
            {title && <h1 style={layoutStyles.title}>{title}</h1>}
            {subtitle && <p style={layoutStyles.subtitle}>{subtitle}</p>}
          </div>
          {actions && (
            <div style={layoutStyles.actions}>
              {actions}
            </div>
          )}
        </div>
      )}
      
      <div style={layoutStyles.content}>
        {children}
      </div>
    </div>
  );
}