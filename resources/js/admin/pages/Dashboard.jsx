import React, { useState, useEffect } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { api } from '../utils/api';
import { formatDate } from '../utils/helpers';

export default function Dashboard() {
  const location = useLocation();
  const navigate = useNavigate();
  const [stats, setStats] = useState(null);
  const [quickActions, setQuickActions] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
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

  // Responsive helpers
  const isMobile = screenSize.width <= 768;
  const isTablet = screenSize.width > 768 && screenSize.width <= 1024;
  const isLargeScreen = screenSize.width > 1440;

  const getGridColumns = () => {
    if (screenSize.width <= 480) return '1fr';
    if (screenSize.width <= 768) return 'repeat(2, 1fr)';
    if (screenSize.width <= 1024) return 'repeat(3, 1fr)';
    if (screenSize.width <= 1440) return 'repeat(4, 1fr)';
    return 'repeat(5, 1fr)';
  };

  const getCardPadding = () => {
    if (isMobile) return '1rem';
    if (isTablet) return '1.25rem';
    return '1.5rem';
  };

  const getContainerPadding = () => {
    if (isMobile) return '1.5rem';
    if (isTablet) return '1.75rem';
    return '2rem';
  };

  useEffect(() => {
    const fetchDashboardData = async () => {
      try {
        setLoading(true);
        const [statsResponse, actionsResponse] = await Promise.all([
          api.dashboard.getStats(),
          api.dashboard.getQuickActions()
        ]);
        
        setStats(statsResponse.data);
        setQuickActions(actionsResponse.data);
        setError(null);
      } catch (err) {
        setError('Error al cargar los datos del dashboard');
        console.error('Dashboard data error:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchDashboardData();
  }, []);

  // StatCard component
  const StatCard = ({ title, icon, color, total, subtitle, onClick, badge = null }) => (
    <div 
      style={{
        backgroundColor: color,
        color: 'white',
        borderRadius: isMobile ? '8px' : '12px',
        padding: getCardPadding(),
        boxShadow: '0 6px 20px rgba(0,0,0,0.5)',
        cursor: 'pointer',
        transition: 'transform 0.2s',
        minHeight: isMobile ? '120px' : '140px',
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'space-between'
      }}
      onClick={onClick}
      onMouseEnter={(e) => e.currentTarget.style.transform = 'translateY(-2px)'}
      onMouseLeave={(e) => e.currentTarget.style.transform = 'translateY(0)'}
    >
      <div style={{ 
        display: 'flex', 
        alignItems: 'center', 
        justifyContent: 'space-between', 
        marginBottom: isMobile ? '0.75rem' : '1rem' 
      }}>
        <i className={icon} style={{ 
          fontSize: isMobile ? '1.5rem' : '2rem', 
          opacity: 0.8 
        }}></i>
        <div style={{ textAlign: 'right' }}>
          <div style={{ 
            fontSize: isMobile ? '1.5rem' : '2rem', 
            fontWeight: '700' 
          }}>{total}</div>
          <div style={{ 
            fontSize: isMobile ? '0.8rem' : '0.9rem', 
            opacity: 0.8 
          }}>Total</div>
        </div>
      </div>
      <div>
        <h3 style={{ 
          margin: 0, 
          fontSize: isMobile ? '1rem' : '1.1rem',
          marginBottom: '0.5rem'
        }}>{title}</h3>
        <div style={{ 
          fontSize: isMobile ? '0.7rem' : '0.8rem', 
          opacity: 0.8,
          lineHeight: '1.3'
        }}>
          {subtitle}
        </div>
        {badge && (
          <div style={{ 
            backgroundColor: 'rgba(255,255,255,0.2)', 
            borderRadius: '4px', 
            padding: '0.25rem 0.5rem', 
            fontSize: '0.7rem', 
            marginTop: '0.5rem',
            display: 'inline-block'
          }}>
            {badge}
          </div>
        )}
      </div>
    </div>
  );
  
  return (
    <div>
      <h1 style={{ fontSize: '2rem', fontWeight: '700', color: '#2563eb', marginBottom: '0.5rem' }}>📊 Dashboard</h1>
      <p style={{ fontSize: '1.1rem', color: '#94a3b8', marginBottom: '2rem' }}>Panel de control de Radio Stereo Umachiri</p>
      
      {/* Navigation Debug Info */}
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: '1rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
        marginBottom: '2rem',
        border: '1px solid #374151'
      }}>
        <h3 style={{ color: '#10b981', marginBottom: '0.5rem' }}>✅ Navegación Funcionando</h3>
        <p style={{ color: '#6ee7b7', fontSize: '0.9rem' }}>
          Ruta actual: <code style={{ backgroundColor: '#374151', padding: '0.2rem 0.4rem', borderRadius: '4px' }}>{location.pathname}</code>
        </p>
        <p style={{ color: '#6ee7b7', fontSize: '0.9rem' }}>
          URL completa: <code style={{ backgroundColor: '#374151', padding: '0.2rem 0.4rem', borderRadius: '4px' }}>{window.location.href}</code>
        </p>
      </div>
      
      {/* Stats Cards */}
      <div style={{
        backgroundColor: '#1f2937',
        borderRadius: '12px',
        padding: window.innerWidth <= 768 ? '1.5rem' : '2rem',
        boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
        marginBottom: window.innerWidth <= 768 ? '1.5rem' : '2rem',
      }}>
        <h2 style={{ 
          color: '#3b82f6', 
          marginBottom: '1rem',
          fontSize: window.innerWidth <= 768 ? '1.5rem' : '1.75rem'
        }}>Estadísticas</h2>
        
        {loading && (
          <div style={{ textAlign: 'center', color: '#94a3b8', padding: '2rem' }}>
            <p>Cargando estadísticas...</p>
          </div>
        )}
        
        {error && (
          <div style={{ 
            backgroundColor: '#ef4444', 
            color: 'white', 
            padding: '1rem', 
            borderRadius: '8px',
            marginBottom: '1rem'
          }}>
            <p>{error}</p>
          </div>
        )}
        
        {stats && (
          <div style={{ 
            display: 'grid', 
            gridTemplateColumns: getGridColumns(),
            gap: isMobile ? '1rem' : '1.5rem'
          }}>
            {/* Noticias */}
            <StatCard
              title="Noticias"
              icon="fas fa-newspaper"
              color="#ef4444"
              total={stats.overview?.total_news || 0}
              subtitle={`${stats.overview?.published_news || 0} publicadas • ${stats.overview?.draft_news || 0} borradores`}
              onClick={() => navigate('/news')}
            />

            {/* Programas */}
            <StatCard
              title="Programas"
              icon="fas fa-broadcast-tower"
              color="#2563eb"
              total={stats.overview?.total_programs || 0}
              subtitle={`${stats.overview?.featured_programs || 0} destacados`}
              onClick={() => navigate('/programs')}
            />

            {/* Eventos */}
            <StatCard
              title="Eventos"
              icon="fas fa-calendar-alt"
              color="#16a34a"
              total={stats.overview?.total_events || 0}
              subtitle={`${stats.overview?.upcoming_events || 0} próximos`}
              onClick={() => navigate('/events')}
            />

            {/* Comentarios */}
            <StatCard
              title="Comentarios"
              icon="fas fa-comments"
              color={stats.overview?.pending_comments > 0 ? '#f59e0b' : '#8b5cf6'}
              total={stats.overview?.total_comments || 0}
              subtitle={`${stats.overview?.pending_comments || 0} pendientes • ${stats.overview?.approved_comments || 0} aprobados`}
              badge={stats.overview?.pending_comments > 0 ? '¡Requiere atención!' : null}
              onClick={() => navigate('/comments')}
            />

            {/* Galerías */}
            <StatCard
              title="Galerías"
              icon="fas fa-images"
              color="#f59e0b"
              total={stats.overview?.total_galleries || 0}
              subtitle="Fotos y álbumes"
              onClick={() => navigate('/galleries')}
            />
          </div>
        )}
      </div>
      
      {/* Quick Actions */}
      {quickActions.length > 0 && (
        <div style={{
          backgroundColor: '#1f2937',
          borderRadius: '12px',
          padding: getContainerPadding(),
          boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
          marginBottom: isMobile ? '1.5rem' : '2rem'
        }}>
          <h2 style={{ 
            color: '#3b82f6', 
            marginBottom: '1rem',
            fontSize: isMobile ? '1.5rem' : '1.75rem'
          }}>Acciones Rápidas</h2>
          <div style={{ 
            display: 'grid', 
            gridTemplateColumns: isMobile ? '1fr' : 
                               isTablet ? 'repeat(2, 1fr)' : 
                               'repeat(auto-fit, minmax(220px, 1fr))', 
            gap: isMobile ? '0.75rem' : '1rem' 
          }}>
            {quickActions.map((action, index) => (
              <button 
                key={index}
                onClick={() => navigate(action.url.replace('/admin', ''))}
                style={{
                  backgroundColor: action.color,
                  color: 'white',
                  border: 'none',
                  borderRadius: isMobile ? '6px' : '8px',
                  padding: isMobile ? '0.75rem' : '1rem',
                  cursor: 'pointer',
                  fontSize: isMobile ? '0.8rem' : '0.9rem',
                  fontWeight: '600',
                  transition: 'all 0.2s',
                  display: 'flex',
                  alignItems: 'center',
                  gap: isMobile ? '0.5rem' : '0.75rem',
                  position: 'relative',
                  minHeight: isMobile ? '60px' : '70px'
                }}
                onMouseEnter={(e) => {
                  e.target.style.transform = 'translateY(-2px)';
                  e.target.style.boxShadow = '0 8px 25px rgba(0,0,0,0.3)';
                }}
                onMouseLeave={(e) => {
                  e.target.style.transform = 'translateY(0)';
                  e.target.style.boxShadow = 'none';
                }}
              >
                <i className={action.icon} style={{ fontSize: '1.2rem' }}></i>
                <div style={{ textAlign: 'left', flex: 1 }}>
                  <div>{action.title}</div>
                  <div style={{ fontSize: '0.7rem', opacity: 0.8 }}>{action.description}</div>
                </div>
                {action.badge && action.badge > 0 && (
                  <div style={{
                    backgroundColor: 'rgba(255,255,255,0.2)',
                    borderRadius: '12px',
                    padding: '0.25rem 0.5rem',
                    fontSize: '0.7rem',
                    fontWeight: '700',
                    minWidth: '20px',
                    textAlign: 'center'
                  }}>
                    {action.badge}
                  </div>
                )}
              </button>
            ))}
          </div>
        </div>
      )}

      {/* Recent Activity */}
      {stats?.recent_activity && stats.recent_activity.length > 0 && (
        <div style={{
          backgroundColor: '#1f2937',
          borderRadius: '12px',
          padding: '2rem',
          boxShadow: '0 4px 12px rgba(0,0,0,0.7)',
        }}>
          <h2 style={{ color: '#3b82f6', marginBottom: '1rem' }}>Actividad Reciente</h2>
          <div style={{ display: 'grid', gap: '0.75rem' }}>
            {stats.recent_activity.slice(0, 8).map((activity, index) => (
              <div key={index} style={{
                display: 'flex',
                alignItems: 'center',
                gap: '1rem',
                padding: '0.75rem',
                backgroundColor: '#374151',
                borderRadius: '6px',
                transition: 'background-color 0.2s'
              }}
              onMouseEnter={(e) => e.target.style.backgroundColor = '#4b5563'}
              onMouseLeave={(e) => e.target.style.backgroundColor = '#374151'}
              >
                <div style={{
                  width: '40px',
                  height: '40px',
                  borderRadius: '50%',
                  backgroundColor: activity.type === 'news' ? '#ef4444' : 
                                   activity.type === 'comment' ? '#8b5cf6' : 
                                   activity.type === 'event' ? '#16a34a' : '#6b7280',
                  display: 'flex',
                  alignItems: 'center',
                  justifyContent: 'center',
                  color: 'white'
                }}>
                  <i className={
                    activity.type === 'news' ? 'fas fa-newspaper' :
                    activity.type === 'comment' ? 'fas fa-comment' :
                    activity.type === 'event' ? 'fas fa-calendar' : 'fas fa-file'
                  } style={{ fontSize: '0.9rem' }}></i>
                </div>
                <div style={{ flex: 1 }}>
                  <div style={{ color: '#e5e7eb', fontWeight: '600', fontSize: '0.9rem' }}>
                    {activity.title}
                  </div>
                  {activity.subtitle && (
                    <div style={{ color: '#9ca3af', fontSize: '0.8rem' }}>
                      {activity.subtitle}
                    </div>
                  )}
                </div>
                <div style={{ color: '#6b7280', fontSize: '0.8rem' }}>
                  {formatDate(activity.created_at)}
                </div>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
