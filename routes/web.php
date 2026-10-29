<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WeatherController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Public news routes
Route::get('/noticias', [NewsController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{id}', [NewsController::class, 'show'])->name('noticias.show');
Route::post('/noticias/{id}/comments', [NewsController::class, 'storeComment'])->name('noticias.comments.store');
// Public sports routes - Direct implementation to avoid conflicts
Route::get('/deportes', function() {
    $sports = App\Models\Sport::where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->paginate(10);
    return view('sports.index', compact('sports'));
})->name('public.sports.index');

Route::get('/deportes/{id}', function($id) {
    $sport = App\Models\Sport::where('status', 'published')->findOrFail($id);
    $relatedSports = App\Models\Sport::where('status', 'published')
        ->where('id', '!=', $sport->id)
        ->inRandomOrder()
        ->limit(5)
        ->get();
    return view('sports.show', compact('sport', 'relatedSports'));
})->name('public.sports.show');

// Simple test route
Route::get('/deportes-test', function() {
    return '<h1>Deportes Test - Esta ruta funciona!</h1><p>Si ves esto, las rutas están funcionando correctamente.</p><a href="/deportes">Ir a Deportes</a>';
});

// Public programs route
Route::get('/programacion', function() {
    $allPrograms = App\Models\Program::all();
    $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

    // Inicializar arreglo agrupado
    $programs = [];
    foreach ($days as $day) {
        $programs[$day] = collect();
    }

    // Agrupar programas por cada día en days_of_week
    foreach ($allPrograms as $program) {
        foreach ($program->days_of_week as $day) {
            if (in_array($day, $days)) {
                $programs[$day]->push($program);
            }
        }
    }

    // Obtener programas destacados
    $featuredPrograms = App\Models\Program::where('is_featured', true)->get();

    return view('programs.index', compact('programs', 'days', 'featuredPrograms'));
})->name('public.programs.index');

// Public events route
Route::get('/eventos', function() {
    $events = App\Models\Event::orderBy('start_time', 'asc')->paginate(10);
    return view('events.index', compact('events'));
})->name('public.events.index');

Route::get('/eventos/{event}', function(App\Models\Event $event) {
    return view('events.show', compact('event'));
})->name('public.events.show');

// Public gallery route
Route::get('/galeria', function() {
    $galleries = App\Models\Gallery::latest()->paginate(12);
    return view('galleries.index', compact('galleries'));
})->name('public.galleries.index');

Route::get('/galeria/{gallery}', function(App\Models\Gallery $gallery) {
    return view('galleries.show', compact('gallery'));
})->name('public.galleries.show');

// Public podcasts for a program
Route::get('/programacion/{program}/podcasts', function(App\Models\Program $program) {
    $podcasts = $program->podcasts()->latest()->get();
    return view('programs.podcasts', compact('program', 'podcasts'));
})->name('public.programs.podcasts');

// Weather API route
Route::get('/api/weather', [WeatherController::class, 'getWeather'])->name('api.weather');

// Storage route for serving images (fallback for Windows symlink issues)
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    
    if (!file_exists($file)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($file);
    return response()->file($file, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*');

// Temporary test route to check news data (no auth required)
Route::get('/debug-news', function () {
    $news = \App\Models\News::all();
    return response()->json($news->map(function($item) {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'image' => $item->image,
            'image_url' => $item->image ? "/images/{$item->image}" : null,
            'image_exists' => $item->image ? file_exists(public_path("images/{$item->image}")) : false
        ];
    }));
});

// Test API route without auth
Route::get('/test-api-news', function () {
    $news = \App\Models\News::paginate(10);
    return response()->json([
        'success' => true,
        'data' => [
            'items' => $news->items(),
            'pagination' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
                'from' => $news->firstItem(),
                'to' => $news->lastItem()
            ]
        ]
    ]);
});

// Admin panel route
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.panel');

// Simple test POST route without CSRF
Route::post('/test-create-dj', function(\Illuminate\Http\Request $request) {
    $dj = \App\Models\Dj::create([
        'name' => $request->name,
        'specialty' => $request->specialty,
        'bio' => $request->bio,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);
    return response()->json(['success' => true, 'data' => $dj, 'message' => 'DJ creado correctamente']);
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Test upload route without CSRF
Route::post('/test-upload-sport', function(\Illuminate\Http\Request $request) {
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'category' => 'required|in:futbol,basquet,voleibol,atletismo,otros',
            'published_at' => 'required|date',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sports', 'public');
            $validated['image'] = $imagePath;
        }
        
        $sport = \App\Models\Sport::create($validated);
        return response()->json(['success' => true, 'data' => $sport, 'message' => 'Noticia deportiva creada correctamente']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Test API routes without auth (disable CSRF for testing)
Route::prefix('test-admin-api')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::get('dashboard/stats', function() {
        // Fetch recent news and comments for the activity feed
        $recentNews = \App\Models\News::latest()->take(5)->get()->map(function($item) {
            return [
                'type' => 'news',
                'title' => 'Nueva noticia publicada',
                'subtitle' => $item->title,
                'created_at' => $item->created_at
            ];
        });

        $recentComments = \App\Models\Comment::latest()->take(3)->get()->map(function($item) {
            return [
                'type' => 'comment',
                'title' => 'Nuevo comentario recibido',
                'subtitle' => 'En: ' . ($item->news->title ?? 'Noticia'),
                'created_at' => $item->created_at
            ];
        });

        // Merge and sort
        $activity = $recentNews->concat($recentComments)->sortByDesc('created_at')->values();

        return response()->json([
            'success' => true,
            'data' => [
                'overview' => [ // React component expects stats inside 'overview' or root? Let's check Dashboard.jsx carefully.
                    // React code: total={stats.overview?.total_news || 0}
                    // So we need to structure it as 'overview' -> keys.
                    'total_news' => \App\Models\News::count(),
                    'published_news' => \App\Models\News::where('status', 'published')->count(),
                    'draft_news' => \App\Models\News::where('status', 'draft')->count(),
                    
                    'total_sports' => \App\Models\Sport::count(),
                    
                    'total_events' => \App\Models\Event::count(),
                    'upcoming_events' => \App\Models\Event::where('start_time', '>', now())->count(),
                    
                    'total_programs' => \App\Models\Program::count(),
                    'featured_programs' => \App\Models\Program::where('is_featured', true)->count(),
                    
                    'total_galleries' => \App\Models\Gallery::count(),
                    
                    'total_djs' => \App\Models\Dj::count(),
                    
                    'total_comments' => \App\Models\Comment::count(),
                    'pending_comments' => \App\Models\Comment::where('status', 'pending')->count(),
                    'approved_comments' => \App\Models\Comment::where('status', 'approved')->count(),
                ],
                'recent_activity' => $activity
            ]
        ]);
    });
    
    Route::get('sports', function() {
        $sports = \App\Models\Sport::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $sports->items(),
                'pagination' => [
                    'current_page' => $sports->currentPage(),
                    'last_page' => $sports->lastPage(),
                    'per_page' => $sports->perPage(),
                    'total' => $sports->total(),
                ]
            ]
        ]);
    });
    
    Route::get('events', function() {
        $events = \App\Models\Event::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $events->items(),
                'pagination' => [
                    'current_page' => $events->currentPage(),
                    'last_page' => $events->lastPage(),
                    'per_page' => $events->perPage(),
                    'total' => $events->total(),
                ]
            ]
        ]);
    });
    
    Route::get('programs', function() {
        $programs = \App\Models\Program::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $programs->items(),
                'pagination' => [
                    'current_page' => $programs->currentPage(),
                    'last_page' => $programs->lastPage(),
                    'per_page' => $programs->perPage(),
                    'total' => $programs->total(),
                ]
            ]
        ]);
    });
    
    Route::get('galleries', function() {
        $galleries = \App\Models\Gallery::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $galleries->items(),
                'pagination' => [
                    'current_page' => $galleries->currentPage(),
                    'last_page' => $galleries->lastPage(),
                    'per_page' => $galleries->perPage(),
                    'total' => $galleries->total(),
                ]
            ]
        ]);
    });
    
    Route::get('djs', function() {
        $djs = \App\Models\DJ::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $djs->items(),
                'pagination' => [
                    'current_page' => $djs->currentPage(),
                    'last_page' => $djs->lastPage(),
                    'per_page' => $djs->perPage(),
                    'total' => $djs->total(),
                ]
            ]
        ]);
    });
    
    Route::get('news', function() {
        $news = \App\Models\News::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $news->items(),
                'pagination' => [
                    'current_page' => $news->currentPage(),
                    'last_page' => $news->lastPage(),
                    'per_page' => $news->perPage(),
                    'total' => $news->total(),
                ]
            ]
        ]);
    });
    
    Route::get('comments', function() {
        $comments = \App\Models\Comment::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $comments->items(),
                'pagination' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'per_page' => $comments->perPage(),
                    'total' => $comments->total(),
                ]
            ]
        ]);
    });
    
    // CRUD Operations for Sports
    Route::post('sports', function(\Illuminate\Http\Request $request) {
        try {
            \Log::info('Creating sport with data:', $request->all());
            \Log::info('Has file:', $request->hasFile('image'));
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'category' => 'required|in:futbol,basquet,voleibol,atletismo,otros',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'is_featured' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                $imagePath = $request->file('image')->store('sports', 'public');
                $validated['image'] = $imagePath;
                \Log::info('Image stored at:', $imagePath);
            }
            
            $sport = \App\Models\Sport::create($validated);
            \Log::info('Sport created:', $sport->toArray());
            
            return response()->json(['success' => true, 'data' => $sport, 'message' => 'Noticia deportiva creada correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error creating sport:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    });
    
    Route::put('sports/{id}', function(\Illuminate\Http\Request $request, $id) {
        $sport = \App\Models\Sport::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'category' => 'required|in:futbol,basquet,voleibol,atletismo,otros',
            'published_at' => 'required|date',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);
        
        // Handle image removal
        if ($request->get('remove_image')) {
            if ($sport->image) {
                \Storage::disk('public')->delete($sport->image);
                $sport->image = null;
            }
        }
        
        // Handle new image upload
        if ($request->hasFile('image')) {
            if ($sport->image) {
                \Storage::disk('public')->delete($sport->image);
            }
            $imagePath = $request->file('image')->store('sports', 'public');
            $validated['image'] = $imagePath;
        }
        
        $sport->update($validated);
        return response()->json(['success' => true, 'data' => $sport, 'message' => 'Noticia deportiva actualizada correctamente']);
    });
    
    Route::get('sports/{id}', function($id) {
        $sport = \App\Models\Sport::findOrFail($id);
        return response()->json(['success' => true, 'data' => $sport]);
    });
    
    Route::delete('sports/{id}', function($id) {
        $sport = \App\Models\Sport::findOrFail($id);
        if ($sport->image) {
            \Storage::disk('public')->delete($sport->image);
        }
        $sport->delete();
        return response()->json(['success' => true, 'message' => 'Noticia deportiva eliminada correctamente']);
    });
    
    // CRUD Operations for Events
    Route::post('events', function(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
        ]);
        
        $event = \App\Models\Event::create($validated);
        return response()->json(['success' => true, 'data' => $event, 'message' => 'Evento creado correctamente']);
    });
    
    Route::put('events/{id}', function(\Illuminate\Http\Request $request, $id) {
        $event = \App\Models\Event::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
        ]);
        
        $event->update($validated);
        return response()->json(['success' => true, 'data' => $event, 'message' => 'Evento actualizado correctamente']);
    });
    
    Route::get('events/{id}', function($id) {
        $event = \App\Models\Event::findOrFail($id);
        return response()->json(['success' => true, 'data' => $event]);
    });
    
    Route::delete('events/{id}', function($id) {
        $event = \App\Models\Event::findOrFail($id);
        if ($event->image) {
            \Storage::disk('public')->delete($event->image);
        }
        $event->delete();
        return response()->json(['success' => true, 'message' => 'Evento eliminado correctamente']);
    });
    
    // CRUD Operations for Programs
    Route::post('programs', function(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'host' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'is_featured' => 'boolean',
        ]);
        
        $program = \App\Models\Program::create($validated);
        return response()->json(['success' => true, 'data' => $program, 'message' => 'Programa creado correctamente']);
    });
    
    Route::put('programs/{id}', function(\Illuminate\Http\Request $request, $id) {
        $program = \App\Models\Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'host' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'days_of_week' => 'required|array',
            'days_of_week.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'is_featured' => 'boolean',
        ]);
        
        $program->update($validated);
        return response()->json(['success' => true, 'data' => $program, 'message' => 'Programa actualizado correctamente']);
    });
    
    Route::get('programs/{id}', function($id) {
        $program = \App\Models\Program::findOrFail($id);
        return response()->json(['success' => true, 'data' => $program]);
    });
    
    Route::delete('programs/{id}', function($id) {
        $program = \App\Models\Program::findOrFail($id);
        $program->delete();
        return response()->json(['success' => true, 'message' => 'Programa eliminado correctamente']);
    });
    
    // News CRUD
    Route::get('news', function() {
        $news = \App\Models\News::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $news->items(),
                'pagination' => [
                    'current_page' => $news->currentPage(),
                    'last_page' => $news->lastPage(),
                    'per_page' => $news->perPage(),
                    'total' => $news->total(),
                ]
            ]
        ]);
    });
    
    Route::post('news', function(\Illuminate\Http\Request $request) {
        try {
            \Log::info('Creating news with data:', $request->all());
            \Log::info('Has file:', $request->hasFile('image'));
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'type' => 'required|in:local,internacional',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'is_featured' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Handle is_featured checkbox (convert to boolean)
            $validated['is_featured'] = $request->has('is_featured') ? true : false;
            
            // Handle image upload
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                $imagePath = $request->file('image')->store('news', 'public');
                $validated['image'] = $imagePath;
                \Log::info('Image stored at:', $imagePath);
            }
            
            $news = \App\Models\News::create($validated);
            \Log::info('News created:', $news->toArray());
            
            return response()->json(['success' => true, 'data' => $news, 'message' => 'Noticia creada correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error creating news:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    });
    
    // Alternative POST route for updates (FormData compatibility)
    Route::post('news/{id}/update', function(\Illuminate\Http\Request $request, $id) {
        try {
            $news = \App\Models\News::findOrFail($id);
            \Log::info('Updating news via POST with data:', $request->all());
            \Log::info('Has file:', $request->hasFile('image'));
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'type' => 'required|in:local,internacional',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'is_featured' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);
            
            // Handle image removal
            if ($request->get('remove_image')) {
                if ($news->image) {
                    \Storage::disk('public')->delete($news->image);
                    $news->image = null;
                }
            }
            
            // Handle new image upload
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                // Delete old image if exists
                if ($news->image) {
                    \Storage::disk('public')->delete($news->image);
                }
                $imagePath = $request->file('image')->store('news', 'public');
                $validated['image'] = $imagePath;
                \Log::info('Image stored at:', $imagePath);
            }
            
            $news->update($validated);
            \Log::info('News updated:', $news->toArray());
            
            return response()->json(['success' => true, 'data' => $news, 'message' => 'Noticia actualizada correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error updating news via POST:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    });

    Route::put('news/{id}', function(\Illuminate\Http\Request $request, $id) {
        try {
            $news = \App\Models\News::findOrFail($id);
            \Log::info('Updating news with data:', $request->all());
            \Log::info('Has file:', $request->hasFile('image'));
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'type' => 'required|in:local,internacional',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'is_featured' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);
            
            // Handle image removal
            if ($request->get('remove_image')) {
                if ($news->image) {
                    \Storage::disk('public')->delete($news->image);
                    $news->image = null;
                }
            }
            
            // Handle new image upload
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                // Delete old image if exists
                if ($news->image) {
                    \Storage::disk('public')->delete($news->image);
                }
                $imagePath = $request->file('image')->store('news', 'public');
                $validated['image'] = $imagePath;
                \Log::info('Image stored at:', $imagePath);
            }
            
            $news->update($validated);
            \Log::info('News updated:', $news->toArray());
            
            return response()->json(['success' => true, 'data' => $news, 'message' => 'Noticia actualizada correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error updating news:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    });
    
    Route::get('news/{id}', function($id) {
        $news = \App\Models\News::findOrFail($id);
        return response()->json(['success' => true, 'data' => $news]);
    });
    
    Route::delete('news/{id}', function($id) {
        $news = \App\Models\News::findOrFail($id);
        if ($news->image) {
            \Storage::disk('public')->delete($news->image);
        }
        $news->delete();
        return response()->json(['success' => true, 'message' => 'Noticia eliminada correctamente']);
    });
    
    // DJs CRUD
    Route::get('djs', function() {
        $djs = \App\Models\Dj::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $djs->items(),
                'pagination' => [
                    'current_page' => $djs->currentPage(),
                    'last_page' => $djs->lastPage(),
                    'per_page' => $djs->perPage(),
                    'total' => $djs->total(),
                ]
            ]
        ]);
    });
    
    Route::post('djs', function(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $dj = \App\Models\Dj::create($validated);
        return response()->json(['success' => true, 'data' => $dj, 'message' => 'DJ creado correctamente']);
    });
    
    Route::put('djs/{id}', function(\Illuminate\Http\Request $request, $id) {
        $dj = \App\Models\Dj::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);
        
        $dj->update($validated);
        return response()->json(['success' => true, 'data' => $dj, 'message' => 'DJ actualizado correctamente']);
    });
    
    Route::get('djs/{id}', function($id) {
        $dj = \App\Models\Dj::findOrFail($id);
        return response()->json(['success' => true, 'data' => $dj]);
    });
    
    Route::delete('djs/{id}', function($id) {
        $dj = \App\Models\Dj::findOrFail($id);
        if ($dj->image) {
            \Storage::disk('public')->delete($dj->image);
        }
        $dj->delete();
        return response()->json(['success' => true, 'message' => 'DJ eliminado correctamente']);
    });
    
    // Galleries CRUD
    Route::get('galleries', function() {
        $galleries = \App\Models\Gallery::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $galleries->items(),
                'pagination' => [
                    'current_page' => $galleries->currentPage(),
                    'last_page' => $galleries->lastPage(),
                    'per_page' => $galleries->perPage(),
                    'total' => $galleries->total(),
                ]
            ]
        ]);
    });
    
    Route::post('galleries', function(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);
        
        $gallery = \App\Models\Gallery::create($validated);
        return response()->json(['success' => true, 'data' => $gallery, 'message' => 'Galería creada correctamente']);
    });
    
    Route::put('galleries/{id}', function(\Illuminate\Http\Request $request, $id) {
        $gallery = \App\Models\Gallery::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);
        
        $gallery->update($validated);
        return response()->json(['success' => true, 'data' => $gallery, 'message' => 'Galería actualizada correctamente']);
    });
    
    Route::get('galleries/{id}', function($id) {
        $gallery = \App\Models\Gallery::findOrFail($id);
        return response()->json(['success' => true, 'data' => $gallery]);
    });
    
    Route::delete('galleries/{id}', function($id) {
        $gallery = \App\Models\Gallery::findOrFail($id);
        $gallery->delete();
        return response()->json(['success' => true, 'message' => 'Galería eliminada correctamente']);
    });
    
    // Comments Management
    Route::get('comments', function() {
        $comments = \App\Models\Comment::paginate(10);
        return response()->json([
            'success' => true,
            'data' => [
                'items' => $comments->items(),
                'pagination' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'per_page' => $comments->perPage(),
                    'total' => $comments->total(),
                ]
            ]
        ]);
    });
    
    Route::post('comments/{id}/approve', function($id) {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => 'Comentario aprobado correctamente']);
    });
    
    Route::delete('comments/{id}', function($id) {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['success' => true, 'message' => 'Comentario eliminado correctamente']);
    });
});

// Simple test route
Route::get('/admin-simple-test', function () {
    return view('layouts.admin-test');
})->name('admin.simple.test');

// Diagnostic route
Route::get('/admin-diagnostic', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'Laravel está funcionando correctamente',
        'timestamp' => now(),
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
        'environment' => app()->environment(),
        'debug' => config('app.debug'),
        'url' => config('app.url'),
        'csrf_token' => csrf_token(),
        'routes' => [
            'admin_dashboard' => route('admin.dashboard'),
            'admin_spa' => url('/admin/dashboard'),
        ]
    ]);
})->name('admin.diagnostic');

// Simple working admin panel
Route::get('/admin-working', function () {
    return view('layouts.admin-simple');
})->name('admin.working');

// Test functional admin panel (no auth required for testing)
Route::get('/admin-functional-test', function () {
    return view('layouts.admin-functional');
})->name('admin.functional.test');

// Demo page
Route::get('/demo-crud', function () {
    return response()->file(public_path('demo-crud.html'));
})->name('demo.crud');

// Test auto-update page
Route::get('/test-auto-update', function () {
    return response()->file(public_path('test-auto-update.html'));
})->name('test.auto.update');

// Test images page
Route::get('/test-images', function () {
    return response()->file(public_path('test-images.html'));
})->name('test.images');

// Admin panel test page
Route::get('/admin-panel-test', function () {
    return response()->file(public_path('admin-panel-test.html'));
})->name('admin.panel.test');

// Final images test page
Route::get('/test-images-final', function () {
    return response()->file(public_path('test-images-final.html'));
})->name('test.images.final');

// Verification page - Images working
Route::get('/verificacion-imagenes', function () {
    return response()->file(public_path('verificacion-imagenes.html'));
})->name('verificacion.imagenes');

// Complete system verification
Route::get('/sistema-completo', function () {
    return response()->file(public_path('sistema-completo.html'));
})->name('sistema.completo');

// Test news images functionality
Route::get('/test-news-images', function () {
    return response()->file(public_path('test-news-images.html'));
})->name('test.news.images');

// Test update news functionality
Route::get('/test-update-news', function () {
    return response()->file(public_path('test-update-news.html'));
})->name('test.update.news');

// Debug create news functionality
Route::get('/debug-create-news', function () {
    return response()->file(public_path('debug-create-news.html'));
})->name('debug.create.news');

// Simple test create news
Route::get('/test-simple-create', function () {
    return response()->file(public_path('test-simple-create.html'));
})->name('test.simple.create');

// Direct route for creating news without CSRF (for testing)
Route::post('/create-news-direct', function(\Illuminate\Http\Request $request) {
    try {
        \Log::info('Direct create news with data:', $request->all());
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'type' => 'required|in:local,internacional',
            'published_at' => 'required|date',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle is_featured checkbox
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            \Log::info('Processing image upload...');
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
            \Log::info('Image stored at:', $imagePath);
        }
        
        $news = \App\Models\News::create($validated);
        \Log::info('News created successfully:', $news->toArray());
        
        return response()->json(['success' => true, 'data' => $news, 'message' => 'Noticia creada correctamente']);
    } catch (\Exception $e) {
        \Log::error('Error creating news directly:', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Test route for React components (temporary - no auth required)
Route::get('/admin-test-react', function () {
    return view('layouts.admin-simple');
})->name('admin.test.react');

// Test route for new Vite layout
Route::get('/admin-vite-test', function () {
    return view('layouts.admin-vite');
})->name('admin.vite.test');

// Admin Panel Routes (with authentication)
Route::prefix('admin')->middleware('auth')->group(function () {
    // API routes for React SPA (these need to be defined first)
    Route::prefix('api')->middleware(['web'])->group(function () {
        // Dashboard API
        Route::get('dashboard/stats', [App\Http\Controllers\Admin\DashboardApiController::class, 'stats']);
        Route::get('dashboard/quick-actions', [App\Http\Controllers\Admin\DashboardApiController::class, 'quickActions']);
        
        // Analytics API
        Route::get('analytics', [App\Http\Controllers\Admin\AnalyticsApiController::class, 'index']);
        
        // News CRUD API
        Route::apiResource('news', App\Http\Controllers\Admin\NewsApiController::class);
        
        // Programs CRUD API
        Route::apiResource('programs', App\Http\Controllers\Admin\ProgramApiController::class);
        
        // Podcasts nested under programs
        Route::apiResource('programs.podcasts', App\Http\Controllers\Admin\PodcastApiController::class);
        
        // Sports CRUD API
        Route::apiResource('sports', App\Http\Controllers\Admin\SportsApiController::class);
        
        // DJs CRUD API
        Route::apiResource('djs', App\Http\Controllers\Admin\DJApiController::class);
        
        // Events CRUD API
        Route::apiResource('events', App\Http\Controllers\Admin\EventApiController::class);
        
        // Galleries CRUD API
        Route::apiResource('galleries', App\Http\Controllers\Admin\GalleryApiController::class);
        Route::post('galleries/{id}/images', [App\Http\Controllers\Admin\GalleryApiController::class, 'addImages']);
        Route::put('galleries/{id}/reorder', [App\Http\Controllers\Admin\GalleryApiController::class, 'reorderImages']);
        
        // Comment Management API
        Route::get('comments', [App\Http\Controllers\Admin\CommentApiController::class, 'index']);
        Route::post('comments/{id}/approve', [App\Http\Controllers\Admin\CommentApiController::class, 'approve']);
        Route::post('comments/{id}/reject', [App\Http\Controllers\Admin\CommentApiController::class, 'reject']);
        Route::delete('comments/{id}', [App\Http\Controllers\Admin\CommentApiController::class, 'destroy']);
        Route::post('comments/bulk-approve', [App\Http\Controllers\Admin\CommentApiController::class, 'bulkApprove']);
        Route::post('comments/bulk-reject', [App\Http\Controllers\Admin\CommentApiController::class, 'bulkReject']);
        Route::delete('comments/bulk-destroy', [App\Http\Controllers\Admin\CommentApiController::class, 'bulkDestroy']);
    });

    // Legacy Blade routes (for backward compatibility)
    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    
    // News CRUD (Blade views)
    Route::resource('noticias', App\Http\Controllers\Admin\NewsController::class)->names('admin.noticias');
    
    // Sports CRUD (Blade views)
    Route::resource('sports', App\Http\Controllers\Admin\SportController::class)->names('admin.sports');
    
    // Programs CRUD (Blade views)
    Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class)->names('admin.programs');
    
    // Events CRUD (Blade views)
    Route::resource('events', App\Http\Controllers\Admin\EventController::class)->names('admin.events');
    
    // Galleries CRUD (Blade views)
    Route::resource('galleries', App\Http\Controllers\Admin\GalleryController::class)->names('admin.galleries');
    
    // Podcasts CRUD (Blade views, nested under programs)
    Route::resource('programs.podcasts', App\Http\Controllers\Admin\PodcastController::class)->except(['show'])->names('admin.programs.podcasts');
    
    // DJs CRUD (Blade views)
    Route::resource('djs', App\Http\Controllers\Admin\DjController::class)->names('admin.djs');
    
    // Comment Management (Blade views)
    Route::get('comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments.index');
    Route::post('comments/{id}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('admin.comments.approve');
    Route::delete('comments/{id}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comments.destroy');

    // Dashboard blade view
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
});

// Test route to verify CSRF is working
Route::get('/test-csrf-status', function() {
    return response()->json([
        'message' => 'CSRF middleware is working',
        'timestamp' => now(),
        'csrf_token' => csrf_token(),
        'middleware_except' => app(\App\Http\Middleware\VerifyCsrfToken::class)->getExcept() ?? 'No custom middleware'
    ]);
});

// Simple test POST without CSRF for verification
Route::post('/simple-test-post', function(\Illuminate\Http\Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'POST request successful without CSRF',
        'data' => $request->all()
    ]);
});

// Final working test page
Route::get('/test-final-working', function () {
    return response()->file(public_path('test-final-working.html'));
})->name('test.final.working');
// Admin API routes that work without CSRF (for development)
Route::prefix('admin/api')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    
    // Dashboard stats
    Route::get('dashboard/stats', function() {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'news_count' => \App\Models\News::count(),
                    'sports_count' => \App\Models\Sport::count(),
                    'events_count' => \App\Models\Event::count(),
                    'programs_count' => \App\Models\Program::count(),
                    'galleries_count' => \App\Models\Gallery::count(),
                    'djs_count' => \App\Models\DJ::count(),
                    'comments_count' => \App\Models\Comment::count(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    });
    
    // News CRUD
    Route::get('news', function(\Illuminate\Http\Request $request) {
        try {
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search');
            $status = $request->get('status');
            $type = $request->get('type');
            
            $query = \App\Models\News::query();
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('content', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%");
                });
            }
            
            if ($status) {
                $query->where('status', $status);
            }
            
            if ($type) {
                $query->where('type', $type);
            }
            
            $news = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'items' => $news->items(),
                    'pagination' => [
                        'current_page' => $news->currentPage(),
                        'last_page' => $news->lastPage(),
                        'per_page' => $news->perPage(),
                        'total' => $news->total(),
                        'from' => $news->firstItem(),
                        'to' => $news->lastItem(),
                        'has_more_pages' => $news->hasMorePages(),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting news: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al obtener noticias: ' . $e->getMessage()], 500);
        }
    });
    
    Route::post('news', function(\Illuminate\Http\Request $request) {
        try {
            \Log::info('Creating news with data:', $request->all());
            \Log::info('Files:', $request->allFiles());
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'type' => 'required|in:local,internacional',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                \Log::info('Processing image upload...');
                $imagePath = $request->file('image')->store('news', 'public');
                $validated['image'] = $imagePath;
                \Log::info('Image stored at: ' . $imagePath);
            }
            
            $news = \App\Models\News::create($validated);
            \Log::info('News created successfully with ID: ' . $news->id);
            
            return response()->json([
                'success' => true, 
                'data' => $news, 
                'message' => 'Noticia creada correctamente'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false, 
                'message' => 'Error de validación', 
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating news: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false, 
                'message' => 'Error al crear la noticia: ' . $e->getMessage()
            ], 500);
        }
    });
    
    Route::get('news/{id}', function($id) {
        try {
            $news = \App\Models\News::findOrFail($id);
            return response()->json(['success' => true, 'data' => $news]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Noticia no encontrada'], 404);
        }
    });
    
    Route::put('news/{id}', function(\Illuminate\Http\Request $request, $id) {
        try {
            $news = \App\Models\News::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'type' => 'required|in:local,internacional',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);
            
            // Handle image removal
            if ($request->get('remove_image')) {
                if ($news->image) {
                    \Storage::disk('public')->delete($news->image);
                    $news->image = null;
                }
            }
            
            // Handle new image upload
            if ($request->hasFile('image')) {
                if ($news->image) {
                    \Storage::disk('public')->delete($news->image);
                }
                $imagePath = $request->file('image')->store('news', 'public');
                $validated['image'] = $imagePath;
            }
            
            $news->update($validated);
            
            return response()->json([
                'success' => true, 
                'data' => $news, 
                'message' => 'Noticia actualizada correctamente'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating news: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error al actualizar la noticia: ' . $e->getMessage()
            ], 500);
        }
    });
    
    // Alternative POST route for updates (for FormData compatibility)
    Route::post('news/{id}', function(\Illuminate\Http\Request $request, $id) {
        try {
            // Check if this is an update request
            if ($request->has('_method') && $request->get('_method') === 'PUT') {
                $news = \App\Models\News::findOrFail($id);
                
                $validated = $request->validate([
                    'title' => 'required|string|max:255',
                    'content' => 'required|string',
                    'author' => 'required|string|max:255',
                    'type' => 'required|in:local,internacional',
                    'published_at' => 'required|date',
                    'status' => 'required|in:draft,published',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'remove_image' => 'nullable|boolean',
                ]);
                
                // Handle image removal
                if ($request->get('remove_image')) {
                    if ($news->image) {
                        \Storage::disk('public')->delete($news->image);
                        $news->image = null;
                    }
                }
                
                // Handle new image upload
                if ($request->hasFile('image')) {
                    if ($news->image) {
                        \Storage::disk('public')->delete($news->image);
                    }
                    $imagePath = $request->file('image')->store('news', 'public');
                    $validated['image'] = $imagePath;
                }
                
                $news->update($validated);
                
                return response()->json([
                    'success' => true, 
                    'data' => $news, 
                    'message' => 'Noticia actualizada correctamente'
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'Método no permitido'], 405);
            
        } catch (\Exception $e) {
            \Log::error('Error in POST update: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Error al actualizar la noticia: ' . $e->getMessage()
            ], 500);
        }
    });
    
    Route::delete('news/{id}', function($id) {
        try {
            $news = \App\Models\News::findOrFail($id);
            
            if ($news->image) {
                \Storage::disk('public')->delete($news->image);
            }
            
            $news->delete();
            
            return response()->json([
                'success' => true, 
                'message' => 'Noticia eliminada correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error al eliminar la noticia: ' . $e->getMessage()
            ], 500);
        }
    });
});