<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SportsApiController extends BaseApiController
{
    /**
     * Display a listing of sports articles.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = Sport::query();
            
            // Apply filters
            $searchableFields = ['title', 'content', 'author', 'category'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            // Filter by category if provided
            if ($request->has('category')) {
                $query->where('category', $request->get('category'));
            }
            
            // Filter by status if provided
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
            
            // Filter by featured if provided
            if ($request->has('is_featured')) {
                $query->where('is_featured', $request->boolean('is_featured'));
            }
            
            $sports = $query->orderBy('created_at', 'desc')->paginate($params['per_page']);
            
            return $this->paginatedResponse($sports, 'Noticias deportivas obtenidas correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener las noticias deportivas', 500);
        }
    }

    /**
     * Store a newly created sports article.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'category' => 'required|in:futbol,basquet,voleibol,atletismo,otros',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'is_featured' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('sports', 'public');
            }

            $sport = Sport::create([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'author' => $validated['author'],
                'category' => $validated['category'],
                'published_at' => $validated['published_at'],
                'status' => $validated['status'],
                'is_featured' => $request->boolean('is_featured'),
                'image' => $imagePath,
            ]);

            return $this->successResponse($sport, 'Noticia deportiva creada correctamente', 201);
            
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la noticia deportiva', 500);
        }
    }

    /**
     * Display the specified sports article.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $sport = Sport::findOrFail($id);
            return $this->successResponse($sport, 'Noticia deportiva obtenida correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Noticia deportiva');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener la noticia deportiva', 500);
        }
    }

    /**
     * Update the specified sports article.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $sport = Sport::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author' => 'required|string|max:255',
                'category' => 'required|in:futbol,basquet,voleibol,atletismo,otros',
                'published_at' => 'required|date',
                'status' => 'required|in:draft,published',
                'is_featured' => 'nullable|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);

            // Handle image removal
            if ($request->get('remove_image')) {
                if ($sport->image) {
                    Storage::disk('public')->delete($sport->image);
                    $sport->image = null;
                }
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                if ($sport->image) {
                    Storage::disk('public')->delete($sport->image);
                }
                $imagePath = $request->file('image')->store('sports', 'public');
                $sport->image = $imagePath;
            }

            $sport->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'author' => $validated['author'],
                'category' => $validated['category'],
                'published_at' => $validated['published_at'],
                'status' => $validated['status'],
                'is_featured' => $request->boolean('is_featured'),
            ]);

            return $this->successResponse($sport, 'Noticia deportiva actualizada correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Noticia deportiva');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la noticia deportiva', 500);
        }
    }

    /**
     * Remove the specified sports article.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $sport = Sport::findOrFail($id);
            
            // Delete associated image
            if ($sport->image) {
                Storage::disk('public')->delete($sport->image);
            }
            
            $sport->delete();
            
            return $this->successResponse(null, 'Noticia deportiva eliminada correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Noticia deportiva');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la noticia deportiva', 500);
        }
    }
}