<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class NewsApiController extends BaseApiController
{
    /**
     * Display a listing of news.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = News::query();
            
            // Apply filters
            $searchableFields = ['title', 'content', 'author'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            // Filter by status if provided
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
            
            // Filter by type if provided
            if ($request->has('type')) {
                $query->where('type', $request->get('type'));
            }
            
            $news = $query->paginate($params['per_page']);
            
            return $this->paginatedResponse($news, 'Noticias obtenidas correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener las noticias', 500);
        }
    }

    /**
     * Store a newly created news article.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'published_at' => 'required|date',
                'type' => 'required|in:local,internacional',
                'status' => 'required|in:draft,published',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('news', 'public');
            }

            $news = News::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'author' => $validated['author'],
                'published_at' => $validated['published_at'],
                'type' => $validated['type'],
                'status' => $validated['status'],
                'image' => $imagePath,
            ]);

            return $this->successResponse($news, 'Noticia creada correctamente', 201);
            
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la noticia', 500);
        }
    }

    /**
     * Display the specified news article.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $news = News::findOrFail($id);
            return $this->successResponse($news, 'Noticia obtenida correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Noticia');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener la noticia', 500);
        }
    }

    /**
     * Update the specified news article.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $news = News::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'published_at' => 'required|date',
                'type' => 'required|in:local,internacional',
                'status' => 'required|in:draft,published',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);

            // Handle image removal
            if ($request->get('remove_image')) {
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                    $news->image = null;
                }
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }
                $imagePath = $request->file('image')->store('news', 'public');
                $news->image = $imagePath;
            }

            $news->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'author' => $validated['author'],
                'published_at' => $validated['published_at'],
                'type' => $validated['type'],
                'status' => $validated['status'],
            ]);

            return $this->successResponse($news, 'Noticia actualizada correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Noticia');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la noticia', 500);
        }
    }

    /**
     * Remove the specified news article.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $news = News::findOrFail($id);
            
            // Delete associated image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            
            $news->delete();
            
            return $this->successResponse(null, 'Noticia eliminada correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Noticia');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la noticia', 500);
        }
    }
}