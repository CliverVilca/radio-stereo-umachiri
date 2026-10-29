<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Admin - Radio Stereo Umachiri</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
            line-height: 1.6;
        }
        
        .admin-container { display: flex; min-height: 100vh; }
        
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e293b 0%, #334155 100%);
            padding: 2rem 1.5rem;
            box-shadow: 4px 0 20px rgba(0,0,0,0.3);
            border-right: 1px solid rgba(148, 163, 184, 0.1);
        }
        
        .sidebar h3 {
            color: #cbd5e1;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.5rem;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #cbd5e1;
            cursor: pointer;
            margin-bottom: 0.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover, .nav-item.active {
            background: #2563eb;
            color: white;
        }
        
        .nav-item i {
            margin-right: 1rem;
            width: 24px;
            text-align: center;
        }
        
        .main-content {
            flex: 1;
            padding: 2rem;
            background: #0f172a;
            color: #f1f5f9;
            overflow-y: auto;
        }
        
        .content-card {
            background: #1f2937;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.7);
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }
        
        .btn-primary { background: #3b82f6; color: white; }
        .btn-success { background: #10b981; color: white; }
        .btn-warning { background: #f59e0b; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        
        .btn:hover { transform: translateY(-2px); opacity: 0.9; }
        .btn-secondary { background: #6b7280; color: white; }
        
        /* Card-based Layout */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .content-card-item {
            background: linear-gradient(145deg, #1e293b, #334155);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .content-card-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(59, 130, 246, 0.3);
        }
        
        .card-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .card-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            border: 2px solid rgba(148, 163, 184, 0.2);
            background: #374151;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 2rem;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
        
        .card-content {
            flex: 1;
            min-width: 0;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .card-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-published { background: rgba(16, 185, 129, 0.2); color: #10b981; }
        .badge-draft { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .badge-featured { background: rgba(139, 92, 246, 0.2); color: #8b5cf6; }
        .badge-category { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
        
        .card-description {
            color: #cbd5e1;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
        }
        
        .card-date {
            color: #94a3b8;
            font-size: 0.85rem;
        }
        
        .card-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-icon {
            padding: 0.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }
        
        .btn-icon:hover {
            transform: scale(1.1);
        }
        
        .btn-edit { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .btn-edit:hover { background: rgba(245, 158, 11, 0.3); }
        
        .btn-delete { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .btn-delete:hover { background: rgba(239, 68, 68, 0.3); }
        
        /* List View Toggle */
        .view-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .view-toggle {
            display: flex;
            background: #1e293b;
            border-radius: 8px;
            padding: 0.25rem;
            border: 1px solid rgba(148, 163, 184, 0.1);
        }
        
        .view-btn {
            padding: 0.5rem 1rem;
            border: none;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .view-btn.active {
            background: #3b82f6;
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .card-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .card-image {
                width: 100px;
                height: 100px;
            }
        }
        
        .loading {
            text-align: center;
            padding: 2rem;
            color: #94a3b8;
        }
        
        .error {
            color: #ef4444;
            background: #7f1d1d;
            padding: 1rem;
            border-radius: 6px;
            margin: 1rem 0;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success { background: #10b981; }
        .notification.error { background: #ef4444; }
        .notification.warning { background: #f59e0b; }
        .notification.info { background: #3b82f6; }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .stat-card {
            background: #374151;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #3b82f6;
        }
        
        .stat-label {
            color: #9ca3af;
            margin-top: 0.5rem;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            animation: fadeIn 0.3s ease;
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: linear-gradient(145deg, #1e293b, #334155);
            border-radius: 20px;
            padding: 2.5rem;
            width: 90%;
            max-width: 650px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: slideIn 0.3s ease;
            border: 1px solid rgba(148, 163, 184, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #374151;
        }
        
        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #f3f4f6;
        }
        
        .close-btn {
            background: none;
            border: none;
            color: #9ca3af;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .close-btn:hover {
            background: #374151;
            color: #f3f4f6;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #e5e7eb;
            font-weight: 500;
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 1rem;
            border: 2px solid #374151;
            border-radius: 12px;
            background: linear-gradient(145deg, #111827, #1f2937);
            color: #f1f5f9;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2), inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-file {
            padding: 0.5rem;
            border: 2px dashed #374151;
            border-radius: 6px;
            background: #111827;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .form-file:hover {
            border-color: #3b82f6;
            background: #1e293b;
        }
        
        .form-file input[type="file"] {
            display: none;
        }
        
        .file-preview {
            margin-top: 1rem;
            text-align: center;
        }
        
        .file-preview img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 6px;
            border: 1px solid #374151;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #374151;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Form Validation Styles */
        .form-input.invalid, .form-textarea.invalid, .form-select.invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        .form-input.valid, .form-textarea.valid, .form-select.valid {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .form-error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .form-success {
            color: #10b981;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Loading Button */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }
        
        .btn .fa-spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Success indicator */
        .success-indicator {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(16, 185, 129, 0.95);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: 600;
            z-index: 2000;
            display: none;
            animation: successPulse 0.5s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        /* Real-time update indicator */
        .realtime-indicator {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            z-index: 1500;
            display: none;
            animation: slideDown 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        @keyframes slideDown {
            from { transform: translateX(-50%) translateY(-100%); }
            to { transform: translateX(-50%) translateY(0); }
        }
        
        @keyframes successPulse {
            0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
            50% { transform: translate(-50%, -50%) scale(1.1); }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <h3>Admin Panel</h3>
            <div class="nav-item active" onclick="showSection('dashboard')">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </div>
            <div class="nav-item" onclick="showSection('news')">
                <i class="fas fa-newspaper"></i> Noticias
            </div>
            <div class="nav-item" onclick="showSection('sports')">
                <i class="fas fa-futbol"></i> Deportes
            </div>
            <div class="nav-item" onclick="showSection('programs')">
                <i class="fas fa-broadcast-tower"></i> Programas
            </div>
            <div class="nav-item" onclick="showSection('djs')">
                <i class="fas fa-microphone"></i> DJs
            </div>
            <div class="nav-item" onclick="showSection('events')">
                <i class="fas fa-calendar-alt"></i> Eventos
            </div>
            <div class="nav-item" onclick="showSection('galleries')">
                <i class="fas fa-images"></i> Galerías
            </div>
            <div class="nav-item" onclick="showSection('comments')">
                <i class="fas fa-comments"></i> Comentarios
            </div>
        </nav>
        
        <!-- Main Content -->
        <main class="main-content">
            <div id="content-area">
                <div class="content-card">
                    <h1>📊 Dashboard</h1>
                    <p>Bienvenido al panel de administración de Radio Stereo Umachiri</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal for Forms -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Crear Elemento</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div id="modalBody">
                <!-- Form content will be inserted here -->
            </div>
        </div>
    </div>
    
    <!-- Success Indicator -->
    <div id="successIndicator" class="success-indicator">
        <i class="fas fa-check-circle"></i> Operación completada exitosamente
    </div>
    
    <!-- Real-time Update Indicator -->
    <div id="realtimeIndicator" class="realtime-indicator">
        <i class="fas fa-bolt"></i> Actualizando en tiempo real...
    </div>

    <script>
        // CSRF Token
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
        
        // API Base URL
        const API_BASE = '/test-admin-api';
        
        // Current section
        let currentSection = 'dashboard';
        
        // Utility function for API calls
        async function apiCall(endpoint, options = {}) {
            console.log('🔄 API Call:', endpoint, options);
            
            // Get fresh CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.Laravel.csrfToken;
            
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            };
            
            const fullUrl = API_BASE + endpoint;
            console.log('📡 Full URL:', fullUrl);
            
            const response = await fetch(fullUrl, {
                ...defaultOptions,
                ...options,
                headers: { ...defaultOptions.headers, ...options.headers }
            });
            
            console.log('📥 Response:', response.status, response.statusText);
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('❌ API Error:', response.status, errorText);
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const result = await response.json();
            console.log('✅ API Result:', result);
            return result;
        }
        
        // Show section function
        async function showSection(section) {
            // Update active nav item
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            event.target.classList.add('active');
            
            currentSection = section;
            const contentArea = document.getElementById('content-area');
            
            // Show loading
            contentArea.innerHTML = '<div class="loading">Cargando...</div>';
            
            try {
                switch(section) {
                    case 'sports':
                        await loadSports();
                        break;
                    case 'events':
                        await loadEvents();
                        break;
                    case 'programs':
                        await loadPrograms();
                        break;
                    case 'galleries':
                        await loadGalleries();
                        break;
                    case 'djs':
                        await loadDJs();
                        break;
                    case 'news':
                        await loadNews();
                        break;
                    case 'comments':
                        await loadComments();
                        break;
                    default:
                        showDashboard();
                }
            } catch (error) {
                console.error('Error loading section:', error);
                contentArea.innerHTML = `
                    <div class="content-card">
                        <div class="error">
                            <h2>❌ Error</h2>
                            <p>Error al cargar la sección: ${error.message}</p>
                            <button class="btn btn-primary" onclick="showSection('${section}')">Reintentar</button>
                        </div>
                    </div>
                `;
            }
        }
        
        // Load Sports
        async function loadSports() {
            const data = await apiCall('/sports');
            const sports = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                🏆 <span>Deportes</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${sports.length} noticias deportivas</p>
                        </div>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <button class="btn btn-success" onclick="createSport()">
                                <i class="fas fa-plus"></i> Crear Noticia Deportiva
                            </button>
                            <button class="btn btn-primary" onclick="testAutoUpdate('sports')" title="Probar actualización automática">
                                <i class="fas fa-sync-alt"></i> Test Auto-Update
                            </button>
                            <button class="btn btn-warning" onclick="testImageUpload()" title="Probar subida de imagen">
                                <i class="fas fa-image"></i> Test Imagen
                            </button>
                            <button class="btn btn-info" onclick="debugImages(); loadSports();" title="Refrescar y debug imágenes">
                                <i class="fas fa-sync"></i> Debug Imágenes
                            </button>
                            <button class="btn" style="background: #8b5cf6; color: white;" onclick="testPreview()" title="Probar vista previa">
                                <i class="fas fa-eye"></i> Test Preview
                            </button>
                        </div>
                    </div>
                    
                    ${sports.length > 0 ? `
                        <div class="content-grid">
                            ${sports.map(sport => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            ${sport.image ? 
                                                `<img src="/storage/${sport.image}" alt="${sport.title}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-futbol\\'></i>';" onload="console.log('✅ Sport image loaded:', this.src)">` : 
                                                '<i class="fas fa-futbol"></i>'
                                            }
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${sport.title}</h3>
                                            <div class="card-meta">
                                                <span class="card-badge badge-category">${getCategoryName(sport.category)}</span>
                                                <span class="card-badge ${sport.status === 'published' ? 'badge-published' : 'badge-draft'}">${sport.status}</span>
                                                ${sport.is_featured ? '<span class="card-badge badge-featured">Destacado</span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${sport.content ? sport.content.substring(0, 120) + '...' : 'Sin descripción'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            <div class="card-date">📅 ${new Date(sport.published_at).toLocaleDateString()}</div>
                                            <div class="card-date">✍️ ${sport.author}</div>
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn-icon btn-edit" onclick="editSport(${sport.id})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteSport(${sport.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">🏆</div>
                            <h3>No hay noticias deportivas</h3>
                            <p>Comienza creando tu primera noticia deportiva</p>
                            <button class="btn btn-primary" onclick="createSport()">Crear Primera Noticia</button>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Helper function for category names
        function getCategoryName(category) {
            const categories = {
                'futbol': 'Fútbol',
                'basquet': 'Básquet', 
                'voleibol': 'Voleibol',
                'atletismo': 'Atletismo',
                'otros': 'Otros'
            };
            return categories[category] || category;
        }
        
        // Load Events
        async function loadEvents() {
            const data = await apiCall('/events');
            const events = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                📅 <span>Eventos</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${events.length} eventos programados</p>
                        </div>
                        <button class="btn btn-success" onclick="createEvent()">
                            <i class="fas fa-plus"></i> Crear Evento
                        </button>
                    </div>
                    
                    ${events.length > 0 ? `
                        <div class="content-grid">
                            ${events.map(event => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            ${event.image ? 
                                                `<img src="/storage/${event.image}" alt="${event.title}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-calendar-alt\\'></i>';" onload="console.log('✅ Event image loaded:', this.src)">` : 
                                                '<i class="fas fa-calendar-alt"></i>'
                                            }
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${event.title}</h3>
                                            <div class="card-meta">
                                                <span class="card-badge badge-category">📍 ${event.location || 'Sin ubicación'}</span>
                                                ${event.is_featured ? '<span class="card-badge badge-featured">Destacado</span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${event.description ? event.description.substring(0, 120) + '...' : 'Sin descripción disponible'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            <div class="card-date">🕐 ${new Date(event.start_time).toLocaleDateString()} ${new Date(event.start_time).toLocaleTimeString()}</div>
                                            ${event.end_time ? `<div class="card-date">🏁 ${new Date(event.end_time).toLocaleDateString()} ${new Date(event.end_time).toLocaleTimeString()}</div>` : ''}
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn-icon btn-edit" onclick="editEvent(${event.id})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteEvent(${event.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">📅</div>
                            <h3>No hay eventos programados</h3>
                            <p>Comienza creando tu primer evento</p>
                            <button class="btn btn-primary" onclick="createEvent()">Crear Primer Evento</button>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Load Programs
        async function loadPrograms() {
            const data = await apiCall('/programs');
            const programs = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                📻 <span>Programas</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${programs.length} programas en parrilla</p>
                        </div>
                        <button class="btn btn-success" onclick="createProgram()">
                            <i class="fas fa-plus"></i> Crear Programa
                        </button>
                    </div>
                    
                    ${programs.length > 0 ? `
                        <div class="content-grid">
                            ${programs.map(program => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            <i class="fas fa-broadcast-tower"></i>
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${program.title}</h3>
                                            <div class="card-meta">
                                                <span class="card-badge badge-category">🎙️ ${program.host}</span>
                                                ${program.is_featured ? '<span class="card-badge badge-featured">Destacado</span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${program.description ? program.description.substring(0, 120) + '...' : 'Programa de radio'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            <div class="card-date">🕐 ${program.start_time} - ${program.end_time}</div>
                                            <div class="card-date">📅 ${program.days_of_week ? program.days_of_week.join(', ') : 'Sin días asignados'}</div>
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn-icon btn-edit" onclick="editProgram(${program.id})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteProgram(${program.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">📻</div>
                            <h3>No hay programas registrados</h3>
                            <p>Comienza creando tu primer programa</p>
                            <button class="btn btn-primary" onclick="createProgram()">Crear Primer Programa</button>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Load Galleries
        async function loadGalleries() {
            const data = await apiCall('/galleries');
            const galleries = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                📸 <span>Galerías</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${galleries.length} galerías de fotos</p>
                        </div>
                        <button class="btn btn-success" onclick="createGallery()">
                            <i class="fas fa-plus"></i> Crear Galería
                        </button>
                    </div>
                    
                    ${galleries.length > 0 ? `
                        <div class="content-grid">
                            ${galleries.map(gallery => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            ${gallery.images && gallery.images.length > 0 ? 
                                                `<img src="/storage/${gallery.images[0]}" alt="${gallery.title}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-images\\'></i>';" onload="console.log('✅ Gallery image loaded:', this.src)">` : 
                                                '<i class="fas fa-images"></i>'
                                            }
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${gallery.title}</h3>
                                            <div class="card-meta">
                                                <span class="card-badge badge-category">📷 ${gallery.images ? gallery.images.length : 0} fotos</span>
                                                ${gallery.is_featured ? '<span class="card-badge badge-featured">Destacada</span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${gallery.description ? gallery.description.substring(0, 120) + '...' : 'Galería de fotos'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            <div class="card-date">📅 ${new Date(gallery.created_at).toLocaleDateString()}</div>
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn-icon btn-edit" onclick="editGallery(${gallery.id})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteGallery(${gallery.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">📸</div>
                            <h3>No hay galerías creadas</h3>
                            <p>Comienza creando tu primera galería</p>
                            <button class="btn btn-primary" onclick="createGallery()">Crear Primera Galería</button>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Load DJs
        async function loadDJs() {
            const data = await apiCall('/djs');
            const djs = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                🎤 <span>DJs</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${djs.length} locutores registrados</p>
                        </div>
                        <button class="btn btn-success" onclick="createDJ()">
                            <i class="fas fa-plus"></i> Crear DJ
                        </button>
                    </div>
                    
                    ${djs.length > 0 ? `
                        <div class="content-grid">
                            ${djs.map(dj => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            ${dj.image ? 
                                                `<img src="/storage/${dj.image}" alt="${dj.name}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-user-tie\\'></i>';" onload="console.log('✅ DJ image loaded:', this.src)">` : 
                                                '<i class="fas fa-user-tie"></i>'
                                            }
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${dj.name}</h3>
                                            <div class="card-meta">
                                                ${dj.specialty ? `<span class="card-badge badge-category">🎵 ${dj.specialty}</span>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${dj.bio ? dj.bio.substring(0, 120) + '...' : 'Locutor de radio profesional'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            ${dj.email ? `<div class="card-date">📧 ${dj.email}</div>` : ''}
                                            ${dj.phone ? `<div class="card-date">📞 ${dj.phone}</div>` : ''}
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn-icon btn-edit" onclick="editDJ(${dj.id})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteDJ(${dj.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">🎤</div>
                            <h3>No hay DJs registrados</h3>
                            <p>Comienza agregando tu primer locutor</p>
                            <button class="btn btn-primary" onclick="createDJ()">Crear Primer DJ</button>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Load News
        async function loadNews() {
            const data = await apiCall('/news');
            const news = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                📰 <span>Noticias</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${news.length} noticias publicadas</p>
                        </div>
                        <button class="btn btn-success" onclick="createNews()">
                            <i class="fas fa-plus"></i> Crear Noticia
                        </button>
                    </div>
                    
                    ${news.length > 0 ? `
                        <div class="content-grid">
                            ${news.map(item => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            ${item.image ? 
                                                `<img src="/storage/${item.image}" alt="${item.title}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-newspaper\\'></i>';" onload="console.log('✅ News image loaded:', this.src)">` : 
                                                '<i class="fas fa-newspaper"></i>'
                                            }
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${item.title}</h3>
                                            <div class="card-meta">
                                                <span class="card-badge badge-category">${getNewsTypeName(item.type)}</span>
                                                <span class="card-badge ${item.status === 'published' ? 'badge-published' : 'badge-draft'}">${item.status}</span>
                                                ${item.is_featured ? '<span class="card-badge badge-featured">Destacada</span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${item.content ? item.content.substring(0, 120) + '...' : 'Sin contenido'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            <div class="card-date">📅 ${new Date(item.published_at).toLocaleDateString()}</div>
                                            <div class="card-date">✍️ ${item.author}</div>
                                        </div>
                                        <div class="card-actions">
                                            <button class="btn-icon btn-edit" onclick="editNews(${item.id})" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" onclick="deleteNews(${item.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">📰</div>
                            <h3>No hay noticias publicadas</h3>
                            <p>Comienza creando tu primera noticia</p>
                            <button class="btn btn-primary" onclick="createNews()">Crear Primera Noticia</button>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Helper function for news type names
        function getNewsTypeName(type) {
            const types = {
                'general': 'General',
                'local': 'Local',
                'nacional': 'Nacional',
                'internacional': 'Internacional'
            };
            return types[type] || type;
        }
        
        // Load Comments
        async function loadComments() {
            const data = await apiCall('/comments');
            const comments = data.data.items || [];
            
            document.getElementById('content-area').innerHTML = `
                <div class="content-card">
                    <div class="view-controls">
                        <div>
                            <h1 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                💬 <span>Comentarios</span>
                            </h1>
                            <p style="margin: 0.5rem 0 0 0; color: #94a3b8;">Total: ${comments.length} comentarios recibidos</p>
                        </div>
                    </div>
                    
                    ${comments.length > 0 ? `
                        <div class="content-grid">
                            ${comments.map(comment => `
                                <div class="content-card-item">
                                    <div class="card-header">
                                        <div class="card-image">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                        <div class="card-content">
                                            <h3 class="card-title">${comment.author_name}</h3>
                                            <div class="card-meta">
                                                <span class="card-badge ${getCommentStatusClass(comment.status)}">${getCommentStatusName(comment.status)}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-description">
                                        ${comment.content ? comment.content.substring(0, 150) + '...' : 'Sin contenido'}
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div>
                                            <div class="card-date">📅 ${new Date(comment.created_at).toLocaleDateString()}</div>
                                            ${comment.email ? `<div class="card-date">📧 ${comment.email}</div>` : ''}
                                        </div>
                                        <div class="card-actions">
                                            ${comment.status === 'pending' ? `
                                                <button class="btn-icon" style="background: rgba(16, 185, 129, 0.2); color: #10b981;" onclick="approveComment(${comment.id})" title="Aprobar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            ` : ''}
                                            <button class="btn-icon btn-delete" onclick="deleteComment(${comment.id})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    ` : `
                        <div class="empty-state">
                            <div class="empty-state-icon">💬</div>
                            <h3>No hay comentarios</h3>
                            <p>Los comentarios de los usuarios aparecerán aquí</p>
                        </div>
                    `}
                </div>
            `;
        }
        
        // Helper functions for comments
        function getCommentStatusClass(status) {
            const classes = {
                'pending': 'badge-draft',
                'approved': 'badge-published',
                'rejected': 'badge-category'
            };
            return classes[status] || 'badge-category';
        }
        
        function getCommentStatusName(status) {
            const names = {
                'pending': 'Pendiente',
                'approved': 'Aprobado',
                'rejected': 'Rechazado'
            };
            return names[status] || status;
        }
        
        // Show Dashboard
        async function showDashboard() {
            try {
                // Load dashboard stats
                const statsData = await apiCall('/dashboard/stats');
                const stats = statsData.data;
                
                document.getElementById('content-area').innerHTML = `
                    <div class="content-card">
                        <h1>📊 Dashboard</h1>
                        <p>Bienvenido al panel de administración de Radio Stereo Umachiri</p>
                        
                        <div class="stats-grid">
                            <div class="stat-card" data-stat="news">
                                <div class="stat-number">${stats.news_count || 0}</div>
                                <div class="stat-label">Noticias</div>
                            </div>
                            <div class="stat-card" data-stat="sports">
                                <div class="stat-number">${stats.sports_count || 0}</div>
                                <div class="stat-label">Deportes</div>
                            </div>
                            <div class="stat-card" data-stat="events">
                                <div class="stat-number">${stats.events_count || 0}</div>
                                <div class="stat-label">Eventos</div>
                            </div>
                            <div class="stat-card" data-stat="programs">
                                <div class="stat-number">${stats.programs_count || 0}</div>
                                <div class="stat-label">Programas</div>
                            </div>
                            <div class="stat-card" data-stat="galleries">
                                <div class="stat-number">${stats.galleries_count || 0}</div>
                                <div class="stat-label">Galerías</div>
                            </div>
                            <div class="stat-card" data-stat="comments">
                                <div class="stat-number">${stats.comments_count || 0}</div>
                                <div class="stat-label">Comentarios</div>
                            </div>
                        </div>
                        
                        <div style="margin-top: 2rem;">
                            <h3>Acciones Rápidas:</h3>
                            <button class="btn btn-primary" onclick="showSection('news')">📰 Gestionar Noticias</button>
                            <button class="btn btn-warning" onclick="showSection('sports')">🏆 Gestionar Deportes</button>
                            <button class="btn btn-success" onclick="showSection('events')">📅 Gestionar Eventos</button>
                            <button class="btn btn-primary" onclick="showSection('programs')">📻 Gestionar Programas</button>
                        </div>
                    </div>
                `;
            } catch (error) {
                console.error('Error loading dashboard:', error);
                document.getElementById('content-area').innerHTML = `
                    <div class="content-card">
                        <h1>📊 Dashboard</h1>
                        <p>Bienvenido al panel de administración de Radio Stereo Umachiri</p>
                        <div style="margin-top: 2rem;">
                            <h3>Acciones Rápidas:</h3>
                            <button class="btn btn-primary" onclick="showSection('news')">📰 Gestionar Noticias</button>
                            <button class="btn btn-warning" onclick="showSection('sports')">🏆 Gestionar Deportes</button>
                            <button class="btn btn-success" onclick="showSection('events')">📅 Gestionar Eventos</button>
                            <button class="btn btn-primary" onclick="showSection('programs')">📻 Gestionar Programas</button>
                        </div>
                    </div>
                `;
            }
        }
        
        // CRUD Functions for Sports
        function createSport() {
            openModal('Crear Noticia Deportiva', getSportForm());
        }
        
        async function editSport(id) {
            try {
                const response = await apiCall(`/sports/${id}`);
                const sport = response.data;
                openModal('Editar Noticia Deportiva', getSportForm(sport));
            } catch (error) {
                showNotification('Error al cargar la noticia deportiva', 'error');
            }
        }
        
        async function submitSportForm(event, id = null) {
            event.preventDefault();
            console.log('🏈 Iniciando submitSportForm, ID:', id);
            
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Validate form before submitting
            if (!validateForm(form)) {
                console.log('❌ Validación de formulario falló');
                return;
            }
            
            console.log('✅ Formulario validado correctamente');
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const method = id ? 'PUT' : 'POST';
                const endpoint = id ? `/sports/${id}` : '/sports';
                
                // Always check for files first
                const imageFile = formData.get('image');
                const hasFiles = imageFile && imageFile.size > 0;
                
                console.log('📁 Checking files:', { hasFiles, imageFile, size: imageFile?.size });
                
                let response;
                if (hasFiles) {
                    console.log('📤 Sending with file upload...');
                    // Send as FormData for file upload
                    response = await fetch(API_BASE + endpoint, {
                        method: method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.Laravel.csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    console.log('📥 File upload response:', response.status);
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('❌ File upload error:', errorText);
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    response = await response.json();
                } else {
                    console.log('📤 Sending without files...');
                    // Send as JSON for regular data
                    const data = {};
                    for (let [key, value] of formData.entries()) {
                        if (key === 'image') continue;
                        if (key === 'is_featured') {
                            data[key] = formData.has('is_featured');
                        } else {
                            data[key] = value;
                        }
                    }
                    
                    console.log('📋 Data to send:', data);
                    
                    response = await apiCall(endpoint, {
                        method: method,
                        body: JSON.stringify(data)
                    });
                }
                
                closeModal();
                showNotification(response.message || (id ? 'Noticia deportiva actualizada correctamente' : 'Noticia deportiva creada correctamente'));
                showSuccessIndicator(id ? 'Noticia deportiva actualizada' : 'Noticia deportiva creada');
                
                console.log('✅ Operación exitosa, actualizando UI automáticamente...', response.data);
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de deportes automáticamente...');
                showUpdateIndicator();
                loadSports();
                
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = 'Error al guardar la noticia deportiva';
                
                if (error.message.includes('422')) {
                    errorMessage = 'Por favor verifica que todos los campos requeridos estén completos';
                } else if (error.message.includes('404')) {
                    errorMessage = 'La noticia deportiva no fue encontrada';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        // CRUD Functions for Events
        function createEvent() {
            openModal('Crear Evento', getEventForm());
        }
        
        async function editEvent(id) {
            try {
                const response = await apiCall(`/events/${id}`);
                const event = response.data;
                openModal('Editar Evento', getEventForm(event));
            } catch (error) {
                showNotification('Error al cargar el evento', 'error');
            }
        }
        
        async function submitEventForm(event, id = null) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Validate form before submitting
            if (!validateForm(form)) {
                return;
            }
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const method = id ? 'PUT' : 'POST';
                const endpoint = id ? `/events/${id}` : '/events';
                
                const data = {};
                for (let [key, value] of formData.entries()) {
                    if (key === 'image') continue;
                    if (key === 'is_featured') {
                        data[key] = formData.has('is_featured');
                    } else {
                        data[key] = value;
                    }
                }
                
                const response = await apiCall(endpoint, {
                    method: method,
                    body: JSON.stringify(data)
                });
                
                closeModal();
                showNotification(response.message || (id ? 'Evento actualizado correctamente' : 'Evento creado correctamente'));
                showSuccessIndicator(id ? 'Evento actualizado' : 'Evento creado');
                
                console.log('✅ Evento guardado, actualizando UI automáticamente...', response.data);
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de eventos automáticamente...');
                loadEvents();
                
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = 'Error al guardar el evento';
                
                if (error.message.includes('422')) {
                    errorMessage = 'Por favor verifica que todos los campos requeridos estén completos';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        // CRUD Functions for Programs
        function createProgram() {
            openModal('Crear Programa', getProgramForm());
        }
        
        async function editProgram(id) {
            try {
                const response = await apiCall(`/programs/${id}`);
                const program = response.data;
                openModal('Editar Programa', getProgramForm(program));
            } catch (error) {
                showNotification('Error al cargar el programa', 'error');
            }
        }
        
        async function submitProgramForm(event, id = null) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const method = id ? 'PUT' : 'POST';
                const endpoint = id ? `/programs/${id}` : '/programs';
                
                const data = {};
                const daysOfWeek = [];
                
                for (let [key, value] of formData.entries()) {
                    if (key === 'days_of_week') {
                        daysOfWeek.push(value);
                    } else if (key === 'is_featured') {
                        data[key] = formData.has('is_featured');
                    } else {
                        data[key] = value;
                    }
                }
                
                data.days_of_week = daysOfWeek;
                
                // Validate that at least one day is selected
                if (daysOfWeek.length === 0) {
                    throw new Error('Debes seleccionar al menos un día de la semana');
                }
                
                const response = await apiCall(endpoint, {
                    method: method,
                    body: JSON.stringify(data)
                });
                
                closeModal();
                showNotification(response.message || (id ? 'Programa actualizado correctamente' : 'Programa creado correctamente'));
                showSuccessIndicator(id ? 'Programa actualizado' : 'Programa creado');
                
                console.log('✅ Programa guardado, actualizando UI automáticamente...', response.data);
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de programas automáticamente...');
                loadPrograms();
                
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = error.message || 'Error al guardar el programa';
                
                if (error.message.includes('422')) {
                    errorMessage = 'Por favor verifica que todos los campos requeridos estén completos';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        // CRUD Functions for DJs
        function createDJ() {
            openModal('Crear DJ', getDJForm());
        }
        
        async function editDJ(id) {
            try {
                const response = await apiCall(`/djs/${id}`);
                const dj = response.data;
                openModal('Editar DJ', getDJForm(dj));
            } catch (error) {
                showNotification('Error al cargar el DJ', 'error');
            }
        }
        
        function getDJForm(dj = null) {
            const isEdit = dj !== null;
            return `
                <form id="djForm" onsubmit="submitDJForm(event, ${isEdit ? dj.id : 'null'})">
                    <div class="form-group">
                        <label class="form-label">Nombre *</label>
                        <input type="text" class="form-input" name="name" value="${isEdit ? dj.name : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Especialidad</label>
                        <input type="text" class="form-input" name="specialty" value="${isEdit ? (dj.specialty || '') : ''}" 
                               placeholder="Ej: Música tropical, Rock, Noticias">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Biografía</label>
                        <textarea class="form-textarea" name="bio" placeholder="Cuéntanos sobre este DJ...">${isEdit ? (dj.bio || '') : ''}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" name="email" value="${isEdit ? (dj.email || '') : ''}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-input" name="phone" value="${isEdit ? (dj.phone || '') : ''}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Foto del DJ</label>
                        <div class="form-file" onclick="document.getElementById('djImage').click()">
                            <input type="file" id="djImage" name="image" accept="image/*" onchange="previewImage(this, 'djImagePreview')">
                            <p>📷 Haz clic para seleccionar una foto</p>
                        </div>
                        <div id="djImagePreview" class="file-preview"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">${isEdit ? 'Actualizar' : 'Crear'} DJ</button>
                    </div>
                </form>
            `;
        }
        
        async function submitDJForm(event, id = null) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Validate form before submitting
            if (!validateForm(form)) {
                return;
            }
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const method = id ? 'PUT' : 'POST';
                const endpoint = id ? `/djs/${id}` : '/djs';
                
                const data = {};
                for (let [key, value] of formData.entries()) {
                    if (key === 'image') continue; // Handle file separately for now
                    data[key] = value;
                }
                
                const response = await apiCall(endpoint, {
                    method: method,
                    body: JSON.stringify(data)
                });
                
                closeModal();
                showNotification(response.message || (id ? 'DJ actualizado correctamente' : 'DJ creado correctamente'));
                showSuccessIndicator(id ? 'DJ actualizado' : 'DJ creado');
                
                console.log('✅ DJ guardado, actualizando UI automáticamente...', response.data);
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de DJs automáticamente...');
                loadDJs();
                
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = 'Error al guardar el DJ';
                
                if (error.message.includes('422')) {
                    errorMessage = 'Por favor verifica que todos los campos requeridos estén completos';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        // CRUD Functions for Galleries
        function createGallery() {
            openModal('Crear Galería', getGalleryForm());
        }
        
        async function editGallery(id) {
            try {
                const response = await apiCall(`/galleries/${id}`);
                const gallery = response.data;
                openModal('Editar Galería', getGalleryForm(gallery));
            } catch (error) {
                showNotification('Error al cargar la galería', 'error');
            }
        }
        
        function getGalleryForm(gallery = null) {
            const isEdit = gallery !== null;
            return `
                <form id="galleryForm" onsubmit="submitGalleryForm(event, ${isEdit ? gallery.id : 'null'})">
                    <div class="form-group">
                        <label class="form-label">Título *</label>
                        <input type="text" class="form-input" name="title" value="${isEdit ? gallery.title : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-textarea" name="description" placeholder="Describe esta galería...">${isEdit ? (gallery.description || '') : ''}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_featured" ${isEdit && gallery.is_featured ? 'checked' : ''}>
                            <label class="form-label">Galería destacada</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Imágenes de la Galería</label>
                        <div class="form-file" onclick="document.getElementById('galleryImages').click()">
                            <input type="file" id="galleryImages" name="images" accept="image/*" multiple onchange="previewMultipleImages(this, 'galleryImagesPreview')">
                            <p>📷 Haz clic para seleccionar múltiples imágenes</p>
                        </div>
                        <div id="galleryImagesPreview" class="file-preview"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">${isEdit ? 'Actualizar' : 'Crear'} Galería</button>
                    </div>
                </form>
            `;
        }
        
        async function submitGalleryForm(event, id = null) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Validate form before submitting
            if (!validateForm(form)) {
                return;
            }
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const method = id ? 'PUT' : 'POST';
                const endpoint = id ? `/galleries/${id}` : '/galleries';
                
                const data = {};
                for (let [key, value] of formData.entries()) {
                    if (key === 'images') continue; // Handle file separately for now
                    if (key === 'is_featured') {
                        data[key] = formData.has('is_featured');
                    } else {
                        data[key] = value;
                    }
                }
                
                const response = await apiCall(endpoint, {
                    method: method,
                    body: JSON.stringify(data)
                });
                
                closeModal();
                showNotification(response.message || (id ? 'Galería actualizada correctamente' : 'Galería creada correctamente'));
                showSuccessIndicator(id ? 'Galería actualizada' : 'Galería creada');
                
                console.log('✅ Galería guardada, actualizando UI automáticamente...', response.data);
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de galerías automáticamente...');
                loadGalleries();
                
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = 'Error al guardar la galería';
                
                if (error.message.includes('422')) {
                    errorMessage = 'Por favor verifica que todos los campos requeridos estén completos';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        // Preview multiple images
        function previewMultipleImages(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';
            
            if (input.files) {
                Array.from(input.files).forEach((file, index) => {
                    if (index < 5) { // Limit to 5 previews
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '100px';
                            img.style.maxHeight = '80px';
                            img.style.margin = '5px';
                            img.style.borderRadius = '4px';
                            img.style.border = '1px solid #374151';
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
                
                if (input.files.length > 5) {
                    const moreText = document.createElement('p');
                    moreText.textContent = `+${input.files.length - 5} más...`;
                    moreText.style.color = '#9ca3af';
                    moreText.style.fontSize = '0.9rem';
                    preview.appendChild(moreText);
                }
            }
        }
        
        // CRUD Functions for News
        function createNews() {
            openModal('Crear Noticia', getNewsForm());
        }
        
        async function editNews(id) {
            try {
                const response = await apiCall(`/news/${id}`);
                const news = response.data;
                openModal('Editar Noticia', getNewsForm(news));
            } catch (error) {
                showNotification('Error al cargar la noticia', 'error');
            }
        }
        
        function getNewsForm(news = null) {
            const isEdit = news !== null;
            return `
                <form id="newsForm" onsubmit="submitNewsForm(event, ${isEdit ? news.id : 'null'})">
                    <div class="form-group">
                        <label class="form-label">Título *</label>
                        <input type="text" class="form-input" name="title" value="${isEdit ? news.title : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Contenido *</label>
                        <textarea class="form-textarea" name="content" required>${isEdit ? news.content : ''}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Autor *</label>
                        <input type="text" class="form-input" name="author" value="${isEdit ? news.author : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tipo *</label>
                        <select class="form-select" name="type" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="general" ${isEdit && news.type === 'general' ? 'selected' : ''}>General</option>
                            <option value="local" ${isEdit && news.type === 'local' ? 'selected' : ''}>Local</option>
                            <option value="nacional" ${isEdit && news.type === 'nacional' ? 'selected' : ''}>Nacional</option>
                            <option value="internacional" ${isEdit && news.type === 'internacional' ? 'selected' : ''}>Internacional</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha de Publicación *</label>
                        <input type="datetime-local" class="form-input" name="published_at" 
                               value="${isEdit ? new Date(news.published_at).toISOString().slice(0, 16) : new Date().toISOString().slice(0, 16)}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado *</label>
                        <select class="form-select" name="status" required>
                            <option value="draft" ${isEdit && news.status === 'draft' ? 'selected' : ''}>Borrador</option>
                            <option value="published" ${isEdit && news.status === 'published' ? 'selected' : ''}>Publicado</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_featured" ${isEdit && news.is_featured ? 'checked' : ''}>
                            <label class="form-label">Noticia destacada</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Imagen</label>
                        ${isEdit && news.image ? `
                            <div style="margin-bottom: 1rem;">
                                <p style="color: #94a3b8; margin-bottom: 0.5rem;">Imagen actual:</p>
                                <div style="position: relative; display: inline-block;">
                                    <img src="/storage/${news.image}" alt="Imagen actual" style="max-width: 150px; max-height: 100px; border-radius: 8px; border: 1px solid #374151;">
                                    <button type="button" onclick="removeCurrentImage('newsImage', 'newsImagePreview')" 
                                            style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 12px;">×</button>
                                </div>
                            </div>
                        ` : ''}
                        <div class="form-file" onclick="document.getElementById('newsImage').click()">
                            <input type="file" id="newsImage" name="image" accept="image/*" onchange="previewImage(this, 'newsImagePreview')">
                            <p>📷 Haz clic para ${isEdit && news.image ? 'cambiar' : 'seleccionar'} imagen</p>
                        </div>
                        <div id="newsImagePreview" class="file-preview"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">${isEdit ? 'Actualizar' : 'Crear'} Noticia</button>
                    </div>
                </form>
            `;
        }
        
        async function submitNewsForm(event, id = null) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Validate form before submitting
            if (!validateForm(form)) {
                return;
            }
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const method = id ? 'PUT' : 'POST';
                const endpoint = id ? `/news/${id}` : '/news';
                
                // For file uploads, send FormData directly
                // Use POST for updates to handle FormData properly
                const actualEndpoint = id ? `/news/${id}/update` : '/news';
                const actualMethod = 'POST';
                
                const response = await fetch(`${API_BASE}${actualEndpoint}`, {
                    method: actualMethod,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });
                
                const result = await response.json();
                
                if (!result.success) {
                    throw new Error(result.message || 'Error en la operación');
                }
                
                closeModal();
                showNotification(result.message || (id ? 'Noticia actualizada correctamente' : 'Noticia creada correctamente'));
                showSuccessIndicator(id ? 'Noticia actualizada' : 'Noticia creada');
                
                console.log('✅ Noticia guardada, actualizando UI automáticamente...', response.data);
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de noticias automáticamente...');
                loadNews();
                
            } catch (error) {
                console.error('Error:', error);
                let errorMessage = 'Error al guardar la noticia';
                
                if (error.message.includes('422')) {
                    errorMessage = 'Por favor verifica que todos los campos requeridos estén completos';
                }
                
                showNotification(errorMessage, 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        function approveComment(id) { alert('Comentario ' + id + ' aprobado'); }
        function deleteComment(id) { if(confirm('¿Eliminar comentario?')) alert('Eliminado comentario ' + id); }
        
        // Notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => notification.classList.add('show'), 100);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }
        
        // Success indicator
        function showSuccessIndicator(message = 'Operación completada exitosamente') {
            const indicator = document.getElementById('successIndicator');
            indicator.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            indicator.style.display = 'block';
            
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 2000);
        }
        
        // Real-time update indicator
        function showRealtimeIndicator(message = 'Actualizando en tiempo real...') {
            const indicator = document.getElementById('realtimeIndicator');
            indicator.innerHTML = `<i class="fas fa-sync-alt fa-spin"></i> ${message}`;
            indicator.style.display = 'block';
            
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 2000);
        }
        
        // Show update indicator for all operations
        function showUpdateIndicator() {
            showRealtimeIndicator('Actualizando automáticamente...');
        }
        
        // Enhanced CRUD functions with notifications and auto-refresh
        async function deleteSport(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar esta noticia deportiva?')) return;
            
            // Add loading state to the delete button
            const deleteBtn = document.querySelector(`button[onclick="deleteSport(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/sports/${id}`, { method: 'DELETE' });
                showNotification('Noticia deportiva eliminada correctamente');
                showSuccessIndicator('Noticia deportiva eliminada');
                
                console.log('✅ Noticia deportiva eliminada, actualizando UI automáticamente...');
                
                // ACTUALIZACIÓN AUTOMÁTICA INMEDIATA - GARANTIZADA
                console.log('🔄 Recargando sección de deportes automáticamente...');
                loadSports();
            } catch (error) {
                showNotification('Error al eliminar la noticia deportiva', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        async function deleteEvent(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar este evento?')) return;
            
            const deleteBtn = document.querySelector(`button[onclick="deleteEvent(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/events/${id}`, { method: 'DELETE' });
                showNotification('Evento eliminado correctamente');
                
                // Remove the card with animation
                const card = deleteBtn.closest('.content-card-item');
                if (card) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        updateStatsCounter('events', -1);
                    }, 300);
                }
                
                // NO recargar - mantener vista actual
            } catch (error) {
                showNotification('Error al eliminar el evento', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        async function deleteProgram(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar este programa?')) return;
            
            const deleteBtn = document.querySelector(`button[onclick="deleteProgram(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/programs/${id}`, { method: 'DELETE' });
                showNotification('Programa eliminado correctamente');
                
                // Remove the card with animation
                const card = deleteBtn.closest('.content-card-item');
                if (card) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        updateStatsCounter('programs', -1);
                    }, 300);
                }
                
                // NO recargar - mantener vista actual
            } catch (error) {
                showNotification('Error al eliminar el programa', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        async function deleteGallery(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar esta galería?')) return;
            
            const deleteBtn = document.querySelector(`button[onclick="deleteGallery(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/galleries/${id}`, { method: 'DELETE' });
                showNotification('Galería eliminada correctamente');
                
                const card = deleteBtn.closest('.content-card-item');
                if (card) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        updateStatsCounter('galleries', -1);
                    }, 300);
                }
                
                // NO recargar - mantener vista actual
            } catch (error) {
                showNotification('Error al eliminar la galería', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        async function deleteDJ(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar este DJ?')) return;
            
            const deleteBtn = document.querySelector(`button[onclick="deleteDJ(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/djs/${id}`, { method: 'DELETE' });
                showNotification('DJ eliminado correctamente');
                
                const card = deleteBtn.closest('.content-card-item');
                if (card) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        updateStatsCounter('djs', -1);
                    }, 300);
                }
                
                // NO recargar - mantener vista actual
            } catch (error) {
                showNotification('Error al eliminar el DJ', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        async function deleteNews(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar esta noticia?')) return;
            
            const deleteBtn = document.querySelector(`button[onclick="deleteNews(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/news/${id}`, { method: 'DELETE' });
                showNotification('Noticia eliminada correctamente');
                
                const card = deleteBtn.closest('.content-card-item');
                if (card) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        updateStatsCounter('news', -1);
                    }, 300);
                }
                
                // NO recargar - mantener vista actual
            } catch (error) {
                showNotification('Error al eliminar la noticia', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        async function approveComment(id) {
            try {
                await apiCall(`/comments/${id}/approve`, { method: 'POST' });
                showNotification('Comentario aprobado correctamente');
                showSection('comments');
            } catch (error) {
                showNotification('Error al aprobar el comentario', 'error');
            }
        }
        
        async function deleteComment(id) {
            if (!confirm('¿Estás seguro de que quieres eliminar este comentario?')) return;
            
            const deleteBtn = document.querySelector(`button[onclick="deleteComment(${id})"]`);
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            try {
                await apiCall(`/comments/${id}`, { method: 'DELETE' });
                showNotification('Comentario eliminado correctamente');
                
                const card = deleteBtn.closest('.content-card-item');
                if (card) {
                    card.style.transform = 'scale(0.8)';
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.remove();
                        updateStatsCounter('comments', -1);
                    }, 300);
                }
                
                // NO recargar - mantener vista actual
            } catch (error) {
                showNotification('Error al eliminar el comentario', 'error');
                deleteBtn.innerHTML = originalText;
                deleteBtn.disabled = false;
            }
        }
        
        // Modal Management
        function openModal(title, content) {
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalBody').innerHTML = content;
            document.getElementById('formModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Add validation to the form
            setTimeout(() => {
                const form = document.querySelector('#formModal form');
                if (form) {
                    addFormValidation(form);
                }
            }, 100);
        }
        
        function closeModal() {
            document.getElementById('formModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.getElementById('formModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('formModal').classList.contains('show')) {
                closeModal();
            }
        });
        
        // Form Templates
        function getSportForm(sport = null) {
            const isEdit = sport !== null;
            return `
                <form id="sportForm" onsubmit="submitSportForm(event, ${isEdit ? sport.id : 'null'})">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-heading"></i> Título *</label>
                        <input type="text" class="form-input" name="title" value="${isEdit ? sport.title : ''}" 
                               placeholder="Ingresa el título de la noticia deportiva" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-align-left"></i> Contenido *</label>
                        <textarea class="form-textarea" name="content" 
                                  placeholder="Escribe el contenido completo de la noticia deportiva..." required>${isEdit ? sport.content : ''}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-user-edit"></i> Autor *</label>
                        <input type="text" class="form-input" name="author" value="${isEdit ? sport.author : ''}" 
                               placeholder="Nombre del autor de la noticia" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-tags"></i> Categoría *</label>
                        <select class="form-select" name="category" required>
                            <option value="">⚽ Seleccionar categoría deportiva</option>
                            <option value="futbol" ${isEdit && sport.category === 'futbol' ? 'selected' : ''}>⚽ Fútbol</option>
                            <option value="basquet" ${isEdit && sport.category === 'basquet' ? 'selected' : ''}>🏀 Básquet</option>
                            <option value="voleibol" ${isEdit && sport.category === 'voleibol' ? 'selected' : ''}>🏐 Voleibol</option>
                            <option value="atletismo" ${isEdit && sport.category === 'atletismo' ? 'selected' : ''}>🏃 Atletismo</option>
                            <option value="otros" ${isEdit && sport.category === 'otros' ? 'selected' : ''}>🏆 Otros</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha de Publicación *</label>
                        <input type="datetime-local" class="form-input" name="published_at" 
                               value="${isEdit ? new Date(sport.published_at).toISOString().slice(0, 16) : new Date().toISOString().slice(0, 16)}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Estado *</label>
                        <select class="form-select" name="status" required>
                            <option value="draft" ${isEdit && sport.status === 'draft' ? 'selected' : ''}>Borrador</option>
                            <option value="published" ${isEdit && sport.status === 'published' ? 'selected' : ''}>Publicado</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_featured" ${isEdit && sport.is_featured ? 'checked' : ''}>
                            <label class="form-label"><i class="fas fa-star"></i> Destacar noticia</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-image"></i> Imagen</label>
                        ${isEdit && sport.image ? `
                            <div style="margin-bottom: 1rem;">
                                <p style="color: #94a3b8; margin-bottom: 0.5rem;">Imagen actual:</p>
                                <div style="position: relative; display: inline-block;">
                                    <img src="/storage/${sport.image}" alt="Imagen actual" style="max-width: 150px; max-height: 100px; border-radius: 8px; border: 1px solid #374151;">
                                    <button type="button" onclick="removeCurrentImage('sportImage', 'sportImagePreview')" 
                                            style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 12px;">×</button>
                                </div>
                                <input type="hidden" name="remove_image" id="removeImageFlag" value="false">
                            </div>
                        ` : ''}
                        <div class="form-file" onclick="document.getElementById('sportImage').click()">
                            <input type="file" id="sportImage" name="image" accept="image/*" onchange="previewImage(this, 'sportImagePreview')">
                            <p><i class="fas fa-cloud-upload-alt"></i> ${isEdit ? 'Cambiar imagen' : 'Seleccionar imagen'}</p>
                            <small style="color: #94a3b8;">Formatos: JPG, PNG, GIF (máx. 2MB)</small>
                        </div>
                        <div id="sportImagePreview" class="file-preview" style="min-height: 50px; border: 1px dashed #374151; border-radius: 8px; padding: 1rem; margin-top: 1rem; text-align: center; color: #94a3b8;">
                            <i class="fas fa-image" style="font-size: 2rem; opacity: 0.5;"></i>
                            <p style="margin: 0.5rem 0 0 0;">La vista previa aparecerá aquí</p>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> ${isEdit ? 'Actualizar' : 'Crear'} Noticia
                        </button>
                    </div>
                </form>
            `;
        }
        
        function getEventForm(event = null) {
            const isEdit = event !== null;
            return `
                <form id="eventForm" onsubmit="submitEventForm(event, ${isEdit ? event.id : 'null'})">
                    <div class="form-group">
                        <label class="form-label">Título *</label>
                        <input type="text" class="form-input" name="title" value="${isEdit ? event.title : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-textarea" name="description">${isEdit ? (event.description || '') : ''}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha y Hora de Inicio *</label>
                        <input type="datetime-local" class="form-input" name="start_time" 
                               value="${isEdit ? new Date(event.start_time).toISOString().slice(0, 16) : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Fecha y Hora de Fin</label>
                        <input type="datetime-local" class="form-input" name="end_time" 
                               value="${isEdit && event.end_time ? new Date(event.end_time).toISOString().slice(0, 16) : ''}">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Ubicación</label>
                        <input type="text" class="form-input" name="location" value="${isEdit ? (event.location || '') : ''}">
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_featured" ${isEdit && event.is_featured ? 'checked' : ''}>
                            <label class="form-label">Evento destacado</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Imagen del Evento</label>
                        <div class="form-file" onclick="document.getElementById('eventImage').click()">
                            <input type="file" id="eventImage" name="image" accept="image/*" onchange="previewImage(this, 'eventImagePreview')">
                            <p>📷 Haz clic para seleccionar una imagen</p>
                        </div>
                        <div id="eventImagePreview" class="file-preview"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">${isEdit ? 'Actualizar' : 'Crear'} Evento</button>
                    </div>
                </form>
            `;
        }
        
        function getProgramForm(program = null) {
            const isEdit = program !== null;
            return `
                <form id="programForm" onsubmit="submitProgramForm(event, ${isEdit ? program.id : 'null'})">
                    <div class="form-group">
                        <label class="form-label">Título del Programa *</label>
                        <input type="text" class="form-input" name="title" value="${isEdit ? program.title : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-textarea" name="description">${isEdit ? (program.description || '') : ''}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Conductor/Host *</label>
                        <input type="text" class="form-input" name="host" value="${isEdit ? program.host : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Hora de Inicio *</label>
                        <input type="time" class="form-input" name="start_time" value="${isEdit ? program.start_time : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Hora de Fin *</label>
                        <input type="time" class="form-input" name="end_time" value="${isEdit ? program.end_time : ''}" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Días de la Semana *</label>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem; margin-top: 0.5rem;">
                            ${['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'].map(day => `
                                <div class="checkbox-group">
                                    <input type="checkbox" name="days_of_week" value="${day}" 
                                           ${isEdit && program.days_of_week && program.days_of_week.includes(day) ? 'checked' : ''}>
                                    <label class="form-label">${day}</label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_featured" ${isEdit && program.is_featured ? 'checked' : ''}>
                            <label class="form-label">Programa destacado</label>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primary">${isEdit ? 'Actualizar' : 'Crear'} Programa</button>
                    </div>
                </form>
            `;
        }
        
        // Image Preview Function
        function previewImage(input, previewId) {
            console.log('🖼️ Preview image called:', input.id, previewId);
            const preview = document.getElementById(previewId);
            
            if (!preview) {
                console.error('❌ Preview element not found:', previewId);
                return;
            }
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                console.log('📁 File selected:', file.name, file.size, file.type);
                
                // Validate file size (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('La imagen debe ser menor a 2MB', 'error');
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showNotification('Por favor selecciona un archivo de imagen válido', 'error');
                    input.value = '';
                    return;
                }
                
                console.log('✅ File validation passed, creating preview...');
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('✅ FileReader loaded, showing preview');
                    preview.innerHTML = `
                        <div style="position: relative; display: inline-block; margin-top: 1rem;">
                            <img src="${e.target.result}" alt="Vista Previa" 
                                 style="max-width: 200px; max-height: 150px; border-radius: 8px; border: 2px solid #3b82f6; box-shadow: 0 4px 8px rgba(0,0,0,0.2);"
                                 onload="console.log('✅ Preview image rendered successfully')">
                            <button type="button" onclick="removeImagePreview('${previewId}', '${input.id}')" 
                                    style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">×</button>
                            <div style="text-align: center; margin-top: 0.5rem; color: #10b981; font-size: 0.9rem;">
                                ✅ Vista previa cargada: ${file.name}
                            </div>
                        </div>
                    `;
                    showNotification('Vista previa cargada correctamente', 'success');
                };
                
                reader.onerror = function() {
                    console.error('❌ FileReader error');
                    showNotification('Error al cargar la vista previa', 'error');
                };
                
                reader.readAsDataURL(file);
            } else {
                console.log('❌ No file selected');
                preview.innerHTML = '';
            }
        }
        
        // Remove image preview
        function removeImagePreview(previewId, inputId) {
            document.getElementById(previewId).innerHTML = '';
            document.getElementById(inputId).value = '';
        }
        
        // Remove current image
        function removeCurrentImage(inputId, previewId) {
            const currentImageDiv = event.target.closest('div').parentNode;
            currentImageDiv.style.display = 'none';
            document.getElementById('removeImageFlag').value = 'true';
            
            // Clear any new image selection
            document.getElementById(inputId).value = '';
            document.getElementById(previewId).innerHTML = '';
        }
        
        // Form validation
        function validateForm(form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                const value = field.value.trim();
                const errorElement = field.parentNode.querySelector('.form-error');
                
                // Remove existing error
                if (errorElement) {
                    errorElement.remove();
                }
                
                field.classList.remove('invalid', 'valid');
                
                if (!value) {
                    field.classList.add('invalid');
                    const error = document.createElement('div');
                    error.className = 'form-error';
                    error.innerHTML = '<i class="fas fa-exclamation-circle"></i> Este campo es requerido';
                    field.parentNode.appendChild(error);
                    isValid = false;
                } else {
                    field.classList.add('valid');
                }
            });
            
            return isValid;
        }
        
        // Add real-time validation
        function addFormValidation(form) {
            const inputs = form.querySelectorAll('input, textarea, select');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required')) {
                        const value = this.value.trim();
                        const errorElement = this.parentNode.querySelector('.form-error');
                        
                        if (errorElement) {
                            errorElement.remove();
                        }
                        
                        this.classList.remove('invalid', 'valid');
                        
                        if (!value) {
                            this.classList.add('invalid');
                            const error = document.createElement('div');
                            error.className = 'form-error';
                            error.innerHTML = '<i class="fas fa-exclamation-circle"></i> Este campo es requerido';
                            this.parentNode.appendChild(error);
                        } else {
                            this.classList.add('valid');
                        }
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('invalid') && this.value.trim()) {
                        this.classList.remove('invalid');
                        this.classList.add('valid');
                        const errorElement = this.parentNode.querySelector('.form-error');
                        if (errorElement) {
                            errorElement.remove();
                        }
                    }
                });
            });
        }
        
        // Update stats counter
        function updateStatsCounter(section, change) {
            const dashboard = document.querySelector('.stats-grid');
            if (dashboard) {
                const statCard = dashboard.querySelector(`[data-stat="${section}"] .stat-number`);
                if (statCard) {
                    const currentValue = parseInt(statCard.textContent) || 0;
                    statCard.textContent = Math.max(0, currentValue + change);
                }
            }
        }
        
        // Add new item to grid with animation
        function addItemToGrid(item, section) {
            let grid = document.querySelector('.content-grid');
            
            // If no grid exists (empty state), create it
            if (!grid) {
                const contentCard = document.querySelector('.content-card');
                if (contentCard) {
                    const emptyState = contentCard.querySelector('.empty-state');
                    if (emptyState) {
                        emptyState.remove();
                    }
                    
                    // Create new grid
                    const newGrid = document.createElement('div');
                    newGrid.className = 'content-grid';
                    contentCard.appendChild(newGrid);
                    grid = newGrid;
                }
            }
            
            if (grid) {
                const cardHtml = generateCardHtml(item, section);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = cardHtml;
                const newCard = tempDiv.firstElementChild;
                
                // Add with animation
                newCard.style.transform = 'scale(0.8)';
                newCard.style.opacity = '0';
                newCard.style.transition = 'all 0.3s ease';
                
                grid.insertBefore(newCard, grid.firstChild);
                
                setTimeout(() => {
                    newCard.style.transform = 'scale(1)';
                    newCard.style.opacity = '1';
                }, 100);
                
                updateStatsCounter(section, 1);
            }
        }
        
        // Update existing item in grid
        function updateItemInGrid(item, section, id) {
            const existingCard = document.querySelector(`[data-item-id="${id}"]`);
            if (existingCard) {
                const cardHtml = generateCardHtml(item, section);
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = cardHtml;
                const newCard = tempDiv.firstElementChild;
                
                // Replace with animation
                existingCard.style.transform = 'scale(0.95)';
                existingCard.style.opacity = '0.7';
                
                setTimeout(() => {
                    existingCard.replaceWith(newCard);
                    newCard.style.transform = 'scale(1.05)';
                    newCard.style.opacity = '1';
                    
                    setTimeout(() => {
                        newCard.style.transform = 'scale(1)';
                    }, 200);
                }, 150);
            } else {
                // If card doesn't exist, add it as new
                addItemToGrid(item, section);
            }
        }
        
        // Generate card HTML for different sections
        function generateCardHtml(item, section) {
            switch(section) {
                case 'sports':
                    return generateSportCard(item);
                case 'events':
                    return generateEventCard(item);
                case 'programs':
                    return generateProgramCard(item);
                case 'djs':
                    return generateDJCard(item);
                case 'galleries':
                    return generateGalleryCard(item);
                case 'news':
                    return generateNewsCard(item);
                default:
                    return '';
            }
        }
        
        // Generate sport card HTML
        function generateSportCard(sport) {
            return `
                <div class="content-card-item" data-item-id="${sport.id}">
                    <div class="card-header">
                        <div class="card-image">
                            ${sport.image ? 
                                `<img src="/storage/${sport.image}" alt="${sport.title}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-futbol\\'></i>';" onload="console.log('✅ Image loaded:', this.src)">` : 
                                '<i class="fas fa-futbol"></i>'
                            }
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">${sport.title}</h3>
                            <div class="card-meta">
                                <span class="card-badge badge-category">${getCategoryName(sport.category)}</span>
                                <span class="card-badge ${sport.status === 'published' ? 'badge-published' : 'badge-draft'}">${sport.status}</span>
                                ${sport.is_featured ? '<span class="card-badge badge-featured">Destacado</span>' : ''}
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-description">
                        ${sport.content ? sport.content.substring(0, 120) + '...' : 'Sin descripción'}
                    </div>
                    
                    <div class="card-footer">
                        <div>
                            <div class="card-date">📅 ${new Date(sport.published_at).toLocaleDateString()}</div>
                            <div class="card-date">✍️ ${sport.author}</div>
                        </div>
                        <div class="card-actions">
                            <button class="btn-icon btn-edit" onclick="editSport(${sport.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-delete" onclick="deleteSport(${sport.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Generate event card HTML
        function generateEventCard(event) {
            return `
                <div class="content-card-item" data-item-id="${event.id}">
                    <div class="card-header">
                        <div class="card-image">
                            ${event.image ? 
                                `<img src="/storage/${event.image}" alt="${event.title}" onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=\\'fas fa-calendar-alt\\'></i>';" onload="console.log('✅ Event image loaded:', this.src)">` : 
                                '<i class="fas fa-calendar-alt"></i>'
                            }
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">${event.title}</h3>
                            <div class="card-meta">
                                <span class="card-badge badge-category">📍 ${event.location || 'Sin ubicación'}</span>
                                ${event.is_featured ? '<span class="card-badge badge-featured">Destacado</span>' : ''}
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-description">
                        ${event.description ? event.description.substring(0, 120) + '...' : 'Sin descripción disponible'}
                    </div>
                    
                    <div class="card-footer">
                        <div>
                            <div class="card-date">🕐 ${new Date(event.start_time).toLocaleDateString()} ${new Date(event.start_time).toLocaleTimeString()}</div>
                            ${event.end_time ? `<div class="card-date">🏁 ${new Date(event.end_time).toLocaleDateString()} ${new Date(event.end_time).toLocaleTimeString()}</div>` : ''}
                        </div>
                        <div class="card-actions">
                            <button class="btn-icon btn-edit" onclick="editEvent(${event.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-delete" onclick="deleteEvent(${event.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Generate program card HTML
        function generateProgramCard(program) {
            return `
                <div class="content-card-item" data-item-id="${program.id}">
                    <div class="card-header">
                        <div class="card-image">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">${program.title}</h3>
                            <div class="card-meta">
                                <span class="card-badge badge-category">🎙️ ${program.host}</span>
                                ${program.is_featured ? '<span class="card-badge badge-featured">Destacado</span>' : ''}
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-description">
                        ${program.description ? program.description.substring(0, 120) + '...' : 'Programa de radio'}
                    </div>
                    
                    <div class="card-footer">
                        <div>
                            <div class="card-date">🕐 ${program.start_time} - ${program.end_time}</div>
                            <div class="card-date">📅 ${program.days_of_week ? program.days_of_week.join(', ') : 'Sin días asignados'}</div>
                        </div>
                        <div class="card-actions">
                            <button class="btn-icon btn-edit" onclick="editProgram(${program.id})" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-delete" onclick="deleteProgram(${program.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Show empty state when no items
        function showEmptyState(section) {
            const contentArea = document.getElementById('content-area');
            const emptyStates = {
                'sports': {
                    icon: '🏆',
                    title: 'No hay noticias deportivas',
                    message: 'Comienza creando tu primera noticia deportiva',
                    action: 'createSport()'
                },
                'events': {
                    icon: '📅',
                    title: 'No hay eventos programados',
                    message: 'Comienza creando tu primer evento',
                    action: 'createEvent()'
                },
                'programs': {
                    icon: '📻',
                    title: 'No hay programas registrados',
                    message: 'Comienza creando tu primer programa',
                    action: 'createProgram()'
                }
            };
            
            const state = emptyStates[section];
            if (state) {
                const grid = document.querySelector('.content-grid');
                if (grid) {
                    grid.innerHTML = `
                        <div class="empty-state" style="grid-column: 1 / -1;">
                            <div class="empty-state-icon">${state.icon}</div>
                            <h3>${state.title}</h3>
                            <p>${state.message}</p>
                            <button class="btn btn-primary" onclick="${state.action}">Crear Primer Elemento</button>
                        </div>
                    `;
                }
            }
        }
        
        // Test auto-update functionality
        function testAutoUpdate(section) {
            showNotification('Probando actualización automática...', 'info');
            showSuccessIndicator('Recargando sección automáticamente...');
            
            console.log('Probando actualización para:', section);
            
            // Recargar la sección actual para demostrar que funciona
            setTimeout(() => {
                switch(section) {
                    case 'sports':
                        loadSports();
                        break;
                    case 'events':
                        loadEvents();
                        break;
                    case 'programs':
                        loadPrograms();
                        break;
                    case 'djs':
                        loadDJs();
                        break;
                    case 'galleries':
                        loadGalleries();
                        break;
                    case 'news':
                        loadNews();
                        break;
                }
                showNotification('Sección actualizada automáticamente', 'success');
            }, 1000);
        }
        
        // Test image upload
        function testImageUpload() {
            console.log('🖼️ Testing image upload...');
            
            // Create a test FormData
            const formData = new FormData();
            formData.append('title', 'Test con Imagen ' + new Date().toLocaleTimeString());
            formData.append('content', 'Esta es una prueba de subida de imagen');
            formData.append('author', 'Sistema de Prueba');
            formData.append('category', 'futbol');
            formData.append('published_at', new Date().toISOString());
            formData.append('status', 'published');
            formData.append('is_featured', false);
            
            // Create a small test image (1x1 pixel PNG)
            const canvas = document.createElement('canvas');
            canvas.width = 100;
            canvas.height = 100;
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = '#3b82f6';
            ctx.fillRect(0, 0, 100, 100);
            ctx.fillStyle = 'white';
            ctx.font = '12px Arial';
            ctx.fillText('TEST', 35, 55);
            
            canvas.toBlob(blob => {
                formData.append('image', blob, 'test-image.png');
                
                console.log('📤 Uploading test image...');
                
                fetch('/test-upload-sport', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('✅ Upload result:', data);
                    if (data.success) {
                        showNotification('Imagen de prueba subida correctamente', 'success');
                        loadSports();
                    } else {
                        showNotification('Error al subir imagen: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('❌ Upload error:', error);
                    showNotification('Error al subir imagen', 'error');
                });
            }, 'image/png');
        }
        
        // Test preview function
        function testPreview() {
            console.log('🖼️ Testing preview function...');
            
            // Create a test image
            const canvas = document.createElement('canvas');
            canvas.width = 200;
            canvas.height = 150;
            const ctx = canvas.getContext('2d');
            
            // Create a gradient background
            const gradient = ctx.createLinearGradient(0, 0, 200, 150);
            gradient.addColorStop(0, '#3b82f6');
            gradient.addColorStop(1, '#8b5cf6');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 200, 150);
            
            // Add text
            ctx.fillStyle = 'white';
            ctx.font = 'bold 16px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('VISTA PREVIA', 100, 70);
            ctx.fillText('FUNCIONA', 100, 90);
            
            // Convert to blob and simulate file selection
            canvas.toBlob(blob => {
                // Create a fake file input
                const fakeInput = document.createElement('input');
                fakeInput.type = 'file';
                fakeInput.id = 'testInput';
                
                // Create a fake file list
                const dt = new DataTransfer();
                const file = new File([blob], 'test-preview.png', { type: 'image/png' });
                dt.items.add(file);
                fakeInput.files = dt.files;
                
                // Create preview area if it doesn't exist
                let previewArea = document.getElementById('testPreviewArea');
                if (!previewArea) {
                    previewArea = document.createElement('div');
                    previewArea.id = 'testPreviewArea';
                    previewArea.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #1f2937; padding: 2rem; border-radius: 12px; z-index: 2000; box-shadow: 0 10px 30px rgba(0,0,0,0.5);';
                    document.body.appendChild(previewArea);
                }
                
                previewArea.innerHTML = `
                    <h3 style="color: #3b82f6; margin-bottom: 1rem;">🖼️ Test de Vista Previa</h3>
                    <div id="testPreview" style="border: 2px dashed #374151; padding: 1rem; border-radius: 8px; text-align: center; color: #94a3b8;">
                        Cargando vista previa...
                    </div>
                    <button onclick="document.body.removeChild(document.getElementById('testPreviewArea'))" 
                            style="margin-top: 1rem; padding: 0.5rem 1rem; background: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">
                        Cerrar
                    </button>
                `;
                
                // Test the preview function
                previewImage(fakeInput, 'testPreview');
                
                showNotification('Test de vista previa ejecutado', 'info');
            }, 'image/png');
        }
        
        // Debug function for images
        function debugImages() {
            console.log('🖼️ Debugging images...');
            
            // Test image URLs
            const testImages = [
                '/storage/sports/MA7COuafYz0yi0ENfEvAjj9u9L8sxxzPzOAoSh27.jpg',
                '/storage/sports/yo7gVzWn0ZXu6Wf3BrGSei8JC0QgfXlKNH1xS43Z.jpg'
            ];
            
            testImages.forEach(url => {
                const img = new Image();
                img.onload = () => console.log('✅ Image loaded:', url);
                img.onerror = () => console.error('❌ Image failed:', url);
                img.src = url;
            });
        }
        
        // Call debug on load
        debugImages();
        
        console.log('✅ Admin Panel loaded successfully!');
    </script>
</body>
</html>