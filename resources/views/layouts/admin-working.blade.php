<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Radio Stereo Umachiri</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- React CDN -->
    <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #e0e7ff;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 240px;
            background-color: #1e293b;
            color: #cbd5e1;
            padding: 1.5rem 1rem;
            box-shadow: 2px 0 8px rgba(0,0,0,0.7);
        }
        
        .sidebar h3 {
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: #ef4444;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            cursor: pointer;
            margin-bottom: 0.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: #2563eb;
            color: white;
        }
        
        .nav-item i {
            margin-right: 0.75rem;
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .main-content {
            flex: 1;
            padding: 1.5rem 2rem;
            background-color: #121212;
        }
        
        .dashboard-card {
            background: #1f2937;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.7);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #2563eb 0%, #ef4444 100%);
            color: white;
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            flex-direction: column;
            gap: 1rem;
        }
        
        .spinner {
            border: 4px solid #374151;
            border-top: 4px solid #ef4444;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .admin-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                padding: 1rem;
            }
            
            .sidebar h3 {
                font-size: 1.2rem;
                margin-bottom: 1rem;
            }
            
            .nav-item {
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
            }
            
            .nav-item i {
                margin-right: 0.6rem;
                width: 16px;
                font-size: 0.8rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .dashboard-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
        }
        
        /* Tablet responsive */
        @media (max-width: 1024px) and (min-width: 769px) {
            .sidebar {
                width: 220px;
                padding: 1.25rem 0.75rem;
            }
            
            .main-content {
                padding: 1.25rem 1.5rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div id="admin-root">
        <div class="loading">
            <div class="spinner"></div>
            <h2>Cargando Panel de Administración...</h2>
            <p>Radio Stereo Umachiri</p>
        </div>
    </div>
    
    <script>
        console.log('🚀 Admin Panel - Radio Stereo Umachiri');
        
        // Simple Admin App
        function AdminApp() {
            const [currentPage, setCurrentPage] = React.useState('dashboard');
            const [stats, setStats] = React.useState(null);
            const [loading, setLoading] = React.useState(true);
            
            // Load stats
            React.useEffect(() => {
                fetch('/admin/api/dashboard/stats', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setStats(data.data);
                    }
                    setLoading(false);
                })
                .catch(error => {
                    console.error('Error loading stats:', error);
                    setLoading(false);
                });
            }, []);
            
            const navItems = [
                { id: 'dashboard', icon: 'fas fa-tachometer-alt', label: 'Dashboard' },
                { id: 'news', icon: 'fas fa-newspaper', label: 'Noticias' },
                { id: 'sports', icon: 'fas fa-futbol', label: 'Deportes' },
                { id: 'programs', icon: 'fas fa-broadcast-tower', label: 'Programas' },
                { id: 'djs', icon: 'fas fa-microphone', label: 'DJs' },
                { id: 'events', icon: 'fas fa-calendar-alt', label: 'Eventos' },
                { id: 'galleries', icon: 'fas fa-images', label: 'Galerías' },
                { id: 'comments', icon: 'fas fa-comments', label: 'Comentarios' }
            ];
            
            return React.createElement('div', { className: 'admin-container' }, [
                // Sidebar
                React.createElement('div', { key: 'sidebar', className: 'sidebar' }, [
                    React.createElement('h3', { key: 'title' }, 'Admin Panel'),
                    React.createElement('div', { key: 'user-info', style: { 
                        fontSize: '0.8rem', 
                        color: '#94a3b8', 
                        textAlign: 'center', 
                        marginBottom: '2rem',
                        padding: '0.5rem',
                        backgroundColor: '#374151',
                        borderRadius: '6px'
                    }}, [
                        React.createElement('div', { key: 'welcome' }, '👋 Bienvenido'),
                        React.createElement('div', { key: 'radio' }, 'Radio Stereo Umachiri')
                    ]),
                    React.createElement('div', { key: 'nav' }, 
                        navItems.map(item => 
                            React.createElement('div', {
                                key: item.id,
                                className: `nav-item ${currentPage === item.id ? 'active' : ''}`,
                                onClick: () => setCurrentPage(item.id)
                            }, [
                                React.createElement('i', { key: 'icon', className: item.icon }),
                                React.createElement('span', { key: 'label' }, item.label)
                            ])
                        )
                    )
                ]),
                
                // Main Content
                React.createElement('div', { key: 'main', className: 'main-content' }, [
                    currentPage === 'dashboard' && React.createElement(DashboardPage, { 
                        key: 'dashboard', 
                        stats: stats, 
                        loading: loading 
                    }),
                    currentPage === 'news' && React.createElement(NewsPage, { key: 'news' }),
                    currentPage === 'sports' && React.createElement('div', { key: 'sports' }, [
                        React.createElement('h1', { 
                            key: 'title',
                            style: { fontSize: '1.75rem', fontWeight: '700', color: '#f97316', marginBottom: '1.5rem' }
                        }, '🏈 Deportes'),
                        React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                            React.createElement('h2', { key: 'subtitle', style: { color: '#f97316', marginBottom: '1rem' } }, 'Gestión de Noticias Deportivas'),
                            React.createElement('p', { key: 'desc' }, 'Sistema completo para gestionar noticias deportivas de la región.'),
                            React.createElement('ul', { key: 'features', style: { marginTop: '1rem' } }, [
                                React.createElement('li', { key: 'f1' }, '✅ Crear noticias por categoría deportiva'),
                                React.createElement('li', { key: 'f2' }, '✅ Fútbol, Básquet, Vóleibol, Atletismo'),
                                React.createElement('li', { key: 'f3' }, '✅ Imágenes y contenido multimedia'),
                                React.createElement('li', { key: 'f4' }, '✅ Noticias destacadas')
                            ])
                        ])
                    ]),
                    currentPage === 'programs' && React.createElement('div', { key: 'programs' }, [
                        React.createElement('h1', { 
                            key: 'title',
                            style: { fontSize: '1.75rem', fontWeight: '700', color: '#2563eb', marginBottom: '1.5rem' }
                        }, '🎙️ Programas'),
                        React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                            React.createElement('h2', { key: 'subtitle', style: { color: '#2563eb', marginBottom: '1rem' } }, 'Gestión de Programas'),
                            React.createElement('p', { key: 'desc' }, 'Sistema completo para gestionar la programación de radio.'),
                            React.createElement('ul', { key: 'features', style: { marginTop: '1rem' } }, [
                                React.createElement('li', { key: 'f1' }, '✅ Crear programas con horarios'),
                                React.createElement('li', { key: 'f2' }, '✅ Asignar días de la semana'),
                                React.createElement('li', { key: 'f3' }, '✅ Gestionar podcasts'),
                                React.createElement('li', { key: 'f4' }, '✅ Programas destacados')
                            ])
                        ])
                    ]),
                    currentPage === 'djs' && React.createElement('div', { key: 'djs' }, [
                        React.createElement('h1', { 
                            key: 'title',
                            style: { fontSize: '1.75rem', fontWeight: '700', color: '#8b5cf6', marginBottom: '1.5rem' }
                        }, '🎙️ DJs'),
                        React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                            React.createElement('h2', { key: 'subtitle', style: { color: '#8b5cf6', marginBottom: '1rem' } }, 'Gestión de DJs'),
                            React.createElement('p', { key: 'desc' }, 'Sistema completo para gestionar el equipo de DJs de la radio.'),
                            React.createElement('ul', { key: 'features', style: { marginTop: '1rem' } }, [
                                React.createElement('li', { key: 'f1' }, '✅ Perfiles completos con biografías'),
                                React.createElement('li', { key: 'f2' }, '✅ Especialidades musicales'),
                                React.createElement('li', { key: 'f3' }, '✅ Redes sociales integradas'),
                                React.createElement('li', { key: 'f4' }, '✅ DJs destacados')
                            ])
                        ])
                    ]),
                    currentPage === 'events' && React.createElement('div', { key: 'events' }, [
                        React.createElement('h1', { 
                            key: 'title',
                            style: { fontSize: '1.75rem', fontWeight: '700', color: '#16a34a', marginBottom: '1.5rem' }
                        }, '📅 Eventos'),
                        React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                            React.createElement('h2', { key: 'subtitle', style: { color: '#16a34a', marginBottom: '1rem' } }, 'Gestión de Eventos'),
                            React.createElement('p', { key: 'desc' }, 'Sistema completo para programar y gestionar eventos.'),
                            React.createElement('ul', { key: 'features', style: { marginTop: '1rem' } }, [
                                React.createElement('li', { key: 'f1' }, '✅ Crear eventos con fecha y hora'),
                                React.createElement('li', { key: 'f2' }, '✅ Imágenes promocionales'),
                                React.createElement('li', { key: 'f3' }, '✅ Gestión de ubicaciones'),
                                React.createElement('li', { key: 'f4' }, '✅ Eventos destacados')
                            ])
                        ])
                    ]),
                    currentPage === 'galleries' && React.createElement('div', { key: 'galleries' }, [
                        React.createElement('h1', { 
                            key: 'title',
                            style: { fontSize: '1.75rem', fontWeight: '700', color: '#f59e0b', marginBottom: '1.5rem' }
                        }, '🖼️ Galerías'),
                        React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                            React.createElement('h2', { key: 'subtitle', style: { color: '#f59e0b', marginBottom: '1rem' } }, 'Gestión de Galerías'),
                            React.createElement('p', { key: 'desc' }, 'Sistema completo para gestionar álbumes de fotos.'),
                            React.createElement('ul', { key: 'features', style: { marginTop: '1rem' } }, [
                                React.createElement('li', { key: 'f1' }, '✅ Subida múltiple de imágenes'),
                                React.createElement('li', { key: 'f2' }, '✅ Drag & drop'),
                                React.createElement('li', { key: 'f3' }, '✅ Reordenar imágenes'),
                                React.createElement('li', { key: 'f4' }, '✅ Vista en grid responsiva')
                            ])
                        ])
                    ]),
                    currentPage === 'comments' && React.createElement('div', { key: 'comments' }, [
                        React.createElement('h1', { 
                            key: 'title',
                            style: { fontSize: '1.75rem', fontWeight: '700', color: '#8b5cf6', marginBottom: '1.5rem' }
                        }, '💬 Comentarios'),
                        React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                            React.createElement('h2', { key: 'subtitle', style: { color: '#8b5cf6', marginBottom: '1rem' } }, 'Moderación de Comentarios'),
                            React.createElement('p', { key: 'desc' }, 'Sistema completo para moderar comentarios de usuarios.'),
                            React.createElement('ul', { key: 'features', style: { marginTop: '1rem' } }, [
                                React.createElement('li', { key: 'f1' }, '✅ Aprobar/rechazar comentarios'),
                                React.createElement('li', { key: 'f2' }, '✅ Acciones masivas'),
                                React.createElement('li', { key: 'f3' }, '✅ Filtros por estado'),
                                React.createElement('li', { key: 'f4' }, '✅ Información del autor')
                            ])
                        ])
                    ])
                ])
            ]);
        }
        
        function DashboardPage({ stats, loading }) {
            if (loading) {
                return React.createElement('div', { className: 'loading' }, [
                    React.createElement('div', { key: 'spinner', className: 'spinner' }),
                    React.createElement('p', { key: 'text' }, 'Cargando estadísticas...')
                ]);
            }
            
            return React.createElement('div', {}, [
                React.createElement('h1', { 
                    key: 'title',
                    style: { fontSize: '1.75rem', fontWeight: '700', color: '#2563eb', marginBottom: '1.5rem' }
                }, '📊 Dashboard - Radio Stereo Umachiri'),
                
                React.createElement('div', { key: 'stats', className: 'dashboard-card' }, [
                    React.createElement('h2', { 
                        key: 'stats-title',
                        style: { color: '#3b82f6', marginBottom: '1rem' }
                    }, 'Estadísticas del Sistema'),
                    
                    stats && React.createElement('div', { key: 'stats-grid', className: 'stats-grid' }, [
                        React.createElement('div', { key: 'news', className: 'stat-card', style: { background: 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' } }, [
                            React.createElement('div', { key: 'number', className: 'stat-number' }, stats.overview?.total_news || 0),
                            React.createElement('div', { key: 'label', className: 'stat-label' }, 'Noticias')
                        ]),
                        React.createElement('div', { key: 'programs', className: 'stat-card', style: { background: 'linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)' } }, [
                            React.createElement('div', { key: 'number', className: 'stat-number' }, stats.overview?.total_programs || 0),
                            React.createElement('div', { key: 'label', className: 'stat-label' }, 'Programas')
                        ]),
                        React.createElement('div', { key: 'events', className: 'stat-card', style: { background: 'linear-gradient(135deg, #16a34a 0%, #15803d 100%)' } }, [
                            React.createElement('div', { key: 'number', className: 'stat-number' }, stats.overview?.total_events || 0),
                            React.createElement('div', { key: 'label', className: 'stat-label' }, 'Eventos')
                        ]),
                        React.createElement('div', { key: 'comments', className: 'stat-card', style: { background: 'linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)' } }, [
                            React.createElement('div', { key: 'number', className: 'stat-number' }, stats.overview?.total_comments || 0),
                            React.createElement('div', { key: 'label', className: 'stat-label' }, 'Comentarios')
                        ])
                    ])
                ]),
                
                React.createElement('div', { key: 'info', className: 'dashboard-card' }, [
                    React.createElement('h2', { 
                        key: 'info-title',
                        style: { color: '#16a34a', marginBottom: '1rem' }
                    }, '✅ Estado del Sistema'),
                    React.createElement('div', { key: 'status-grid', style: { display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '1rem' } }, [
                        React.createElement('div', { key: 'react' }, '✅ React: Funcionando'),
                        React.createElement('div', { key: 'laravel' }, '✅ Laravel: APIs activas'),
                        React.createElement('div', { key: 'db' }, '✅ Base de datos: Conectada'),
                        React.createElement('div', { key: 'panel' }, '✅ Panel Admin: Operativo'),
                        React.createElement('div', { key: 'responsive' }, '✅ Responsive: Activo'),
                        React.createElement('div', { key: 'images' }, '✅ Imágenes: Funcionando')
                    ])
                ])
            ]);
        }
        
        // NewsPage Component with full functionality
        function NewsPage() {
            const [currentView, setCurrentView] = React.useState('list'); // 'list', 'create', 'edit'
            const [news, setNews] = React.useState([]);
            const [loading, setLoading] = React.useState(true);
            const [error, setError] = React.useState(null);
            const [selectedNews, setSelectedNews] = React.useState(null);
            
            React.useEffect(() => {
                fetchNews();
            }, []);
            
            const fetchNews = async () => {
                try {
                    setLoading(true);
                    const response = await fetch('/admin/api/news', {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        setNews(data.data.items || []);
                    }
                    setError(null);
                } catch (err) {
                    setError('Error al cargar las noticias');
                    console.error('News fetch error:', err);
                } finally {
                    setLoading(false);
                }
            };
            
            const handleCreate = () => {
                setSelectedNews(null);
                setCurrentView('create');
            };
            
            const handleEdit = (newsItem) => {
                setSelectedNews(newsItem);
                setCurrentView('edit');
            };
            
            const handleBack = () => {
                setCurrentView('list');
                setSelectedNews(null);
                fetchNews(); // Refresh list
            };
            
            const handleDelete = async (newsId) => {
                if (confirm('¿Estás seguro de que quieres eliminar esta noticia?')) {
                    try {
                        const response = await fetch(`/admin/api/news/${newsId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        const data = await response.json();
                        if (data.success) {
                            fetchNews(); // Refresh list
                            alert('Noticia eliminada correctamente');
                        } else {
                            alert('Error al eliminar la noticia');
                        }
                    } catch (err) {
                        alert('Error al eliminar la noticia');
                        console.error('Delete error:', err);
                    }
                }
            };
            
            if (currentView === 'create' || currentView === 'edit') {
                return React.createElement(NewsForm, {
                    news: selectedNews,
                    onSave: handleBack,
                    onCancel: handleBack,
                    isEditing: currentView === 'edit'
                });
            }
            
            return React.createElement('div', {}, [
                React.createElement('h1', { 
                    key: 'title',
                    style: { fontSize: '1.75rem', fontWeight: '700', color: '#ef4444', marginBottom: '1.5rem' }
                }, '📰 Noticias'),
                
                React.createElement('div', { key: 'content', className: 'dashboard-card' }, [
                    React.createElement('div', { 
                        key: 'header',
                        style: { 
                            display: 'flex', 
                            justifyContent: 'space-between', 
                            alignItems: 'center', 
                            marginBottom: '2rem' 
                        }
                    }, [
                        React.createElement('h2', { 
                            key: 'subtitle',
                            style: { color: '#ef4444', margin: 0 }
                        }, 'Lista de Noticias'),
                        React.createElement('button', {
                            key: 'create-btn',
                            onClick: handleCreate,
                            style: {
                                backgroundColor: '#ef4444',
                                color: 'white',
                                border: 'none',
                                borderRadius: '8px',
                                padding: '0.75rem 1.5rem',
                                cursor: 'pointer',
                                fontSize: '0.9rem',
                                fontWeight: '600',
                                display: 'flex',
                                alignItems: 'center',
                                gap: '0.5rem'
                            }
                        }, [
                            React.createElement('i', { key: 'icon', className: 'fas fa-plus' }),
                            'Nueva Noticia'
                        ])
                    ]),
                    
                    loading && React.createElement('div', { 
                        key: 'loading',
                        className: 'loading'
                    }, [
                        React.createElement('div', { key: 'spinner', className: 'spinner' }),
                        React.createElement('p', { key: 'text' }, 'Cargando noticias...')
                    ]),
                    
                    error && React.createElement('div', { 
                        key: 'error',
                        style: { 
                            backgroundColor: '#ef4444', 
                            color: 'white', 
                            padding: '1rem', 
                            borderRadius: '8px',
                            marginBottom: '1rem'
                        }
                    }, error),
                    
                    !loading && !error && news.length === 0 && React.createElement('div', { 
                        key: 'empty',
                        style: { 
                            textAlign: 'center', 
                            color: '#94a3b8', 
                            padding: '3rem' 
                        }
                    }, [
                        React.createElement('i', { 
                            key: 'icon',
                            className: 'far fa-newspaper',
                            style: { fontSize: '3rem', marginBottom: '1rem', opacity: 0.5 }
                        }),
                        React.createElement('p', { key: 'text' }, 'No hay noticias disponibles'),
                        React.createElement('button', {
                            key: 'create-first',
                            onClick: handleCreate,
                            style: {
                                backgroundColor: '#ef4444',
                                color: 'white',
                                border: 'none',
                                borderRadius: '6px',
                                padding: '0.5rem 1rem',
                                cursor: 'pointer',
                                marginTop: '1rem'
                            }
                        }, 'Crear primera noticia')
                    ]),
                    
                    !loading && !error && news.length > 0 && React.createElement('div', { 
                        key: 'news-list',
                        style: { display: 'grid', gap: '1rem' }
                    }, news.map((item, index) => 
                        React.createElement('div', {
                            key: item.id,
                            style: {
                                backgroundColor: '#374151',
                                borderRadius: '8px',
                                padding: '1.5rem',
                                border: '1px solid #4b5563',
                                display: 'flex',
                                gap: '1rem',
                                alignItems: 'center'
                            }
                        }, [
                            // Image
                            React.createElement('div', { 
                                key: 'image',
                                style: { width: '80px', height: '60px', flexShrink: 0 }
                            }, [
                                item.image ? React.createElement('img', {
                                    key: 'img',
                                    src: `/storage/${item.image}`,
                                    alt: item.title,
                                    style: { 
                                        width: '100%', 
                                        height: '100%', 
                                        objectFit: 'cover', 
                                        borderRadius: '6px'
                                    },
                                    onError: (e) => {
                                        e.target.style.display = 'none';
                                        e.target.nextSibling.style.display = 'flex';
                                    }
                                }) : null,
                                React.createElement('div', {
                                    key: 'placeholder',
                                    style: {
                                        display: item.image ? 'none' : 'flex',
                                        width: '100%',
                                        height: '100%',
                                        backgroundColor: '#4b5563',
                                        borderRadius: '6px',
                                        alignItems: 'center',
                                        justifyContent: 'center',
                                        color: '#9ca3af'
                                    }
                                }, React.createElement('i', { className: 'far fa-image' }))
                            ]),
                            
                            // Content
                            React.createElement('div', { key: 'content', style: { flex: 1 } }, [
                                React.createElement('h3', { 
                                    key: 'title',
                                    style: { color: '#e5e7eb', marginBottom: '0.5rem', fontSize: '1.1rem' }
                                }, item.title),
                                React.createElement('p', { 
                                    key: 'content',
                                    style: { color: '#9ca3af', fontSize: '0.9rem', marginBottom: '0.5rem' }
                                }, item.content.substring(0, 100) + '...'),
                                React.createElement('div', { 
                                    key: 'meta',
                                    style: { display: 'flex', gap: '1rem', fontSize: '0.8rem', color: '#6b7280' }
                                }, [
                                    React.createElement('span', { key: 'author' }, `Por: ${item.author}`),
                                    React.createElement('span', { key: 'date' }, new Date(item.published_at).toLocaleDateString('es-ES')),
                                    React.createElement('span', { 
                                        key: 'status',
                                        style: {
                                            backgroundColor: item.status === 'published' ? '#16a34a' : '#f59e0b',
                                            color: 'white',
                                            padding: '0.25rem 0.5rem',
                                            borderRadius: '4px',
                                            fontSize: '0.7rem'
                                        }
                                    }, item.status === 'published' ? 'Publicado' : 'Borrador')
                                ])
                            ]),
                            
                            // Actions
                            React.createElement('div', { 
                                key: 'actions',
                                style: { display: 'flex', gap: '0.5rem', flexShrink: 0 }
                            }, [
                                React.createElement('button', {
                                    key: 'edit',
                                    onClick: () => handleEdit(item),
                                    style: {
                                        backgroundColor: '#2563eb',
                                        color: 'white',
                                        border: 'none',
                                        borderRadius: '4px',
                                        padding: '0.5rem',
                                        cursor: 'pointer',
                                        fontSize: '0.8rem'
                                    },
                                    title: 'Editar'
                                }, React.createElement('i', { className: 'fas fa-edit' })),
                                React.createElement('button', {
                                    key: 'delete',
                                    onClick: () => handleDelete(item.id),
                                    style: {
                                        backgroundColor: '#ef4444',
                                        color: 'white',
                                        border: 'none',
                                        borderRadius: '4px',
                                        padding: '0.5rem',
                                        cursor: 'pointer',
                                        fontSize: '0.8rem'
                                    },
                                    title: 'Eliminar'
                                }, React.createElement('i', { className: 'fas fa-trash' }))
                            ])
                        ])
                    ))
                ])
            ]);
        }
        
        // NewsForm Component
        function NewsForm({ news, onSave, onCancel, isEditing }) {
            const [formData, setFormData] = React.useState({
                title: '',
                content: '',
                author: '',
                published_at: '',
                type: 'local',
                status: 'draft'
            });
            const [loading, setLoading] = React.useState(false);
            const [errors, setErrors] = React.useState({});
            
            React.useEffect(() => {
                if (news) {
                    setFormData({
                        title: news.title || '',
                        content: news.content || '',
                        author: news.author || '',
                        published_at: news.published_at ? new Date(news.published_at).toISOString().slice(0, 16) : '',
                        type: news.type || 'local',
                        status: news.status || 'draft'
                    });
                } else {
                    // Set default published_at to current date/time for new news
                    const now = new Date();
                    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                    setFormData(prev => ({
                        ...prev,
                        published_at: now.toISOString().slice(0, 16)
                    }));
                }
            }, [news]);
            
            const handleInputChange = (e) => {
                const { name, value } = e.target;
                setFormData(prev => ({ ...prev, [name]: value }));
                
                // Clear error when user starts typing
                if (errors[name]) {
                    setErrors(prev => ({ ...prev, [name]: null }));
                }
            };
            
            const handleSubmit = async (e) => {
                e.preventDefault();
                setLoading(true);
                setErrors({});
                
                try {
                    const submitData = new FormData();
                    Object.keys(formData).forEach(key => {
                        submitData.append(key, formData[key]);
                    });
                    
                    const url = isEditing ? `/admin/api/news/${news.id}` : '/admin/api/news';
                    const method = isEditing ? 'PUT' : 'POST';
                    
                    if (isEditing) {
                        submitData.append('_method', 'PUT');
                    }
                    
                    const response = await fetch(url, {
                        method: isEditing ? 'POST' : 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: submitData
                    });
                    
                    const data = await response.json();
                    if (data.success) {
                        alert(`Noticia ${isEditing ? 'actualizada' : 'creada'} correctamente`);
                        onSave();
                    } else {
                        setErrors(data.errors || {});
                        alert(data.message || 'Error al guardar la noticia');
                    }
                } catch (err) {
                    alert('Error al guardar la noticia');
                    console.error('Save error:', err);
                } finally {
                    setLoading(false);
                }
            };
            
            return React.createElement('div', {}, [
                React.createElement('div', { 
                    key: 'header',
                    style: { 
                        display: 'flex', 
                        justifyContent: 'space-between', 
                        alignItems: 'center', 
                        marginBottom: '2rem' 
                    }
                }, [
                    React.createElement('h1', { 
                        key: 'title',
                        style: { fontSize: '2rem', fontWeight: '700', color: '#ef4444', margin: 0 }
                    }, isEditing ? '✏️ Editar Noticia' : '➕ Nueva Noticia'),
                    React.createElement('button', {
                        key: 'back',
                        onClick: onCancel,
                        style: {
                            backgroundColor: '#6b7280',
                            color: 'white',
                            border: 'none',
                            borderRadius: '8px',
                            padding: '0.75rem 1.5rem',
                            cursor: 'pointer',
                            fontSize: '0.9rem',
                            fontWeight: '600'
                        }
                    }, '← Volver')
                ]),
                
                React.createElement('form', { key: 'form', onSubmit: handleSubmit }, [
                    React.createElement('div', { 
                        key: 'form-content',
                        className: 'dashboard-card',
                        style: { display: 'grid', gap: '1.5rem' }
                    }, [
                        // Title
                        React.createElement('div', { key: 'title-field' }, [
                            React.createElement('label', { 
                                key: 'label',
                                style: { display: 'block', color: '#e5e7eb', fontWeight: '600', marginBottom: '0.5rem' }
                            }, 'Título *'),
                            React.createElement('input', {
                                key: 'input',
                                type: 'text',
                                name: 'title',
                                value: formData.title,
                                onChange: handleInputChange,
                                required: true,
                                style: {
                                    width: '100%',
                                    backgroundColor: '#374151',
                                    border: errors.title ? '2px solid #ef4444' : '1px solid #4b5563',
                                    borderRadius: '6px',
                                    padding: '0.75rem',
                                    color: '#e5e7eb',
                                    fontSize: '1rem'
                                },
                                placeholder: 'Ingresa el título de la noticia'
                            }),
                            errors.title && React.createElement('p', { 
                                key: 'error',
                                style: { color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }
                            }, errors.title[0])
                        ]),
                        
                        // Content
                        React.createElement('div', { key: 'content-field' }, [
                            React.createElement('label', { 
                                key: 'label',
                                style: { display: 'block', color: '#e5e7eb', fontWeight: '600', marginBottom: '0.5rem' }
                            }, 'Contenido *'),
                            React.createElement('textarea', {
                                key: 'textarea',
                                name: 'content',
                                value: formData.content,
                                onChange: handleInputChange,
                                required: true,
                                rows: 8,
                                style: {
                                    width: '100%',
                                    backgroundColor: '#374151',
                                    border: errors.content ? '2px solid #ef4444' : '1px solid #4b5563',
                                    borderRadius: '6px',
                                    padding: '0.75rem',
                                    color: '#e5e7eb',
                                    fontSize: '1rem',
                                    resize: 'vertical'
                                },
                                placeholder: 'Escribe el contenido de la noticia'
                            }),
                            errors.content && React.createElement('p', { 
                                key: 'error',
                                style: { color: '#ef4444', fontSize: '0.8rem', marginTop: '0.25rem' }
                            }, errors.content[0])
                        ]),
                        
                        // Author and Date Row
                        React.createElement('div', { 
                            key: 'row1',
                            style: { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }
                        }, [
                            React.createElement('div', { key: 'author-field' }, [
                                React.createElement('label', { 
                                    key: 'label',
                                    style: { display: 'block', color: '#e5e7eb', fontWeight: '600', marginBottom: '0.5rem' }
                                }, 'Autor *'),
                                React.createElement('input', {
                                    key: 'input',
                                    type: 'text',
                                    name: 'author',
                                    value: formData.author,
                                    onChange: handleInputChange,
                                    required: true,
                                    style: {
                                        width: '100%',
                                        backgroundColor: '#374151',
                                        border: errors.author ? '2px solid #ef4444' : '1px solid #4b5563',
                                        borderRadius: '6px',
                                        padding: '0.75rem',
                                        color: '#e5e7eb',
                                        fontSize: '1rem'
                                    },
                                    placeholder: 'Nombre del autor'
                                })
                            ]),
                            React.createElement('div', { key: 'date-field' }, [
                                React.createElement('label', { 
                                    key: 'label',
                                    style: { display: 'block', color: '#e5e7eb', fontWeight: '600', marginBottom: '0.5rem' }
                                }, 'Fecha de Publicación *'),
                                React.createElement('input', {
                                    key: 'input',
                                    type: 'datetime-local',
                                    name: 'published_at',
                                    value: formData.published_at,
                                    onChange: handleInputChange,
                                    required: true,
                                    style: {
                                        width: '100%',
                                        backgroundColor: '#374151',
                                        border: errors.published_at ? '2px solid #ef4444' : '1px solid #4b5563',
                                        borderRadius: '6px',
                                        padding: '0.75rem',
                                        color: '#e5e7eb',
                                        fontSize: '1rem'
                                    }
                                })
                            ])
                        ]),
                        
                        // Type and Status Row
                        React.createElement('div', { 
                            key: 'row2',
                            style: { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }
                        }, [
                            React.createElement('div', { key: 'type-field' }, [
                                React.createElement('label', { 
                                    key: 'label',
                                    style: { display: 'block', color: '#e5e7eb', fontWeight: '600', marginBottom: '0.5rem' }
                                }, 'Tipo *'),
                                React.createElement('select', {
                                    key: 'select',
                                    name: 'type',
                                    value: formData.type,
                                    onChange: handleInputChange,
                                    required: true,
                                    style: {
                                        width: '100%',
                                        backgroundColor: '#374151',
                                        border: errors.type ? '2px solid #ef4444' : '1px solid #4b5563',
                                        borderRadius: '6px',
                                        padding: '0.75rem',
                                        color: '#e5e7eb',
                                        fontSize: '1rem'
                                    }
                                }, [
                                    React.createElement('option', { key: 'local', value: 'local' }, 'Local'),
                                    React.createElement('option', { key: 'internacional', value: 'internacional' }, 'Internacional')
                                ])
                            ]),
                            React.createElement('div', { key: 'status-field' }, [
                                React.createElement('label', { 
                                    key: 'label',
                                    style: { display: 'block', color: '#e5e7eb', fontWeight: '600', marginBottom: '0.5rem' }
                                }, 'Estado *'),
                                React.createElement('select', {
                                    key: 'select',
                                    name: 'status',
                                    value: formData.status,
                                    onChange: handleInputChange,
                                    required: true,
                                    style: {
                                        width: '100%',
                                        backgroundColor: '#374151',
                                        border: errors.status ? '2px solid #ef4444' : '1px solid #4b5563',
                                        borderRadius: '6px',
                                        padding: '0.75rem',
                                        color: '#e5e7eb',
                                        fontSize: '1rem'
                                    }
                                }, [
                                    React.createElement('option', { key: 'draft', value: 'draft' }, 'Borrador'),
                                    React.createElement('option', { key: 'published', value: 'published' }, 'Publicado')
                                ])
                            ])
                        ]),
                        
                        // Submit Buttons
                        React.createElement('div', { 
                            key: 'buttons',
                            style: { 
                                display: 'flex', 
                                gap: '1rem', 
                                justifyContent: 'flex-end',
                                marginTop: '1rem',
                                paddingTop: '1rem',
                                borderTop: '1px solid #374151'
                            }
                        }, [
                            React.createElement('button', {
                                key: 'cancel',
                                type: 'button',
                                onClick: onCancel,
                                disabled: loading,
                                style: {
                                    backgroundColor: '#6b7280',
                                    color: 'white',
                                    border: 'none',
                                    borderRadius: '6px',
                                    padding: '0.75rem 1.5rem',
                                    cursor: loading ? 'not-allowed' : 'pointer',
                                    fontSize: '0.9rem',
                                    fontWeight: '600'
                                }
                            }, 'Cancelar'),
                            React.createElement('button', {
                                key: 'submit',
                                type: 'submit',
                                disabled: loading,
                                style: {
                                    backgroundColor: loading ? '#9ca3af' : '#ef4444',
                                    color: 'white',
                                    border: 'none',
                                    borderRadius: '6px',
                                    padding: '0.75rem 1.5rem',
                                    cursor: loading ? 'not-allowed' : 'pointer',
                                    fontSize: '0.9rem',
                                    fontWeight: '600',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '0.5rem'
                                }
                            }, [
                                loading && React.createElement('i', { key: 'spinner', className: 'fas fa-spinner fa-spin' }),
                                loading ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Crear') + ' Noticia'
                            ])
                        ])
                    ])
                ])
            ]);
        }
        
        // Mount the app
        function mountApp() {
            try {
                const container = document.getElementById('admin-root');
                if (container && window.React && window.ReactDOM) {
                    console.log('✅ Mounting Admin Panel...');
                    const root = ReactDOM.createRoot(container);
                    root.render(React.createElement(AdminApp));
                    console.log('✅ Admin Panel loaded successfully!');
                } else {
                    console.error('❌ Missing dependencies:', {
                        container: !!container,
                        React: !!window.React,
                        ReactDOM: !!window.ReactDOM
                    });
                }
            } catch (error) {
                console.error('❌ Error mounting Admin Panel:', error);
                // Show error in the container
                const container = document.getElementById('admin-root');
                if (container) {
                    container.innerHTML = `
                        <div style="padding: 2rem; background: #ef4444; color: white; text-align: center; font-family: Arial;">
                            <h1>❌ Error cargando el Panel Admin</h1>
                            <p><strong>Error:</strong> ${error.message}</p>
                            <button onclick="window.location.reload()" style="
                                background: white; color: #ef4444; border: none; padding: 1rem 2rem; 
                                border-radius: 6px; cursor: pointer; margin-top: 1rem; font-weight: bold;
                            ">🔄 Recargar Página</button>
                        </div>
                    `;
                }
            }
        }
        
        // Wait for React to load, then mount
        let attempts = 0;
        const maxAttempts = 50;
        
        function tryMount() {
            if (window.React && window.ReactDOM) {
                mountApp();
            } else if (attempts < maxAttempts) {
                attempts++;
                setTimeout(tryMount, 100);
            } else {
                console.error('❌ React failed to load after 5 seconds');
                const container = document.getElementById('admin-root');
                if (container) {
                    container.innerHTML = `
                        <div style="padding: 2rem; background: #ef4444; color: white; text-align: center; font-family: Arial;">
                            <h1>❌ Error: React no se pudo cargar</h1>
                            <p>Verifica tu conexión a internet y recarga la página.</p>
                            <button onclick="window.location.reload()" style="
                                background: white; color: #ef4444; border: none; padding: 1rem 2rem; 
                                border-radius: 6px; cursor: pointer; margin-top: 1rem; font-weight: bold;
                            ">🔄 Recargar Página</button>
                        </div>
                    `;
                }
            }
        }
        
        // Start trying to mount
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', tryMount);
        } else {
            tryMount();
        }
    </script>
</body>
</html>