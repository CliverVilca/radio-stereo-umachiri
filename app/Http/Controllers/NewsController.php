<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line


class NewsController extends Controller
{
    public function index()
    {
        $noticias = News::where('status', 'published') // ✅ FILTRAR POR PUBLICADAS
                      ->where('published_at', '<=', now()) // ✅ SOLO NOTICIAS CON FECHA PASADA
                      ->orderBy('published_at', 'desc')
                      ->paginate(10);
        
        return view('noticias.index', compact('noticias'));
    }

    public function show($id)
    {
        $noticia = News::where('status', 'published') // ✅ FILTRAR POR PUBLICADAS
                      ->where('published_at', '<=', now()) // ✅ SOLO NOTICIAS CON FECHA PASADA
                      ->with('comments')
                      ->findOrFail($id);
        
        $comments = $noticia->comments()->latest()->get();
        $relatedNoticias = News::where('status', 'published') // ✅ FILTRAR POR PUBLICADAS
                              ->where('published_at', '<=', now()) // ✅ SOLO NOTICIAS CON FECHA PASADA
                              ->where('id', '!=', $noticia->id)
                              ->inRandomOrder()
                              ->limit(5)
                              ->get();

        return view('noticias.detalle', compact('noticia', 'comments', 'relatedNoticias'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $noticia = News::where('status', 'published') // ✅ FILTRAR POR PUBLICADAS
                      ->where('published_at', '<=', now()) // ✅ SOLO NOTICIAS CON FECHA PASADA
                      ->findOrFail($id);

        $comment = $noticia->comments()->create([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comentario añadido correctamente.');
    }
}
