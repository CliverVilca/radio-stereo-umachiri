<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GalleryApiController extends BaseApiController
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = Gallery::query();
            
            // Apply filters
            $searchableFields = ['title', 'description'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            $galleries = $query->paginate($params['per_page']);
            
            return $this->paginatedResponse($galleries, 'Galerías obtenidas correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener las galerías', 500);
        }
    }

    /**
     * Store a newly created gallery.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('galleries', 'public');
                }
            }

            $gallery = Gallery::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'images' => $imagePaths,
            ]);

            return $this->successResponse($gallery, 'Galería creada correctamente', 201);
            
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la galería', 500);
        }
    }

    /**
     * Display the specified gallery.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $gallery = Gallery::findOrFail($id);
            return $this->successResponse($gallery, 'Galería obtenida correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Galería');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener la galería', 500);
        }
    }

    /**
     * Update the specified gallery.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'new_images' => 'nullable|array',
                'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_images' => 'nullable|array',
                'remove_images.*' => 'string', // Image paths to remove
            ]);

            // Handle image removal
            if ($request->has('remove_images')) {
                $currentImages = $gallery->images ?? [];
                $imagesToRemove = $validated['remove_images'];
                
                foreach ($imagesToRemove as $imageToRemove) {
                    if (in_array($imageToRemove, $currentImages)) {
                        Storage::disk('public')->delete($imageToRemove);
                        $currentImages = array_filter($currentImages, function($img) use ($imageToRemove) {
                            return $img !== $imageToRemove;
                        });
                    }
                }
                
                $gallery->images = array_values($currentImages);
            }

            // Handle new image uploads
            if ($request->hasFile('new_images')) {
                $currentImages = $gallery->images ?? [];
                
                foreach ($request->file('new_images') as $image) {
                    $currentImages[] = $image->store('galleries', 'public');
                }
                
                $gallery->images = $currentImages;
            }

            $gallery->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);

            return $this->successResponse($gallery, 'Galería actualizada correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Galería');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la galería', 500);
        }
    }

    /**
     * Remove the specified gallery.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            // Delete all associated images
            if ($gallery->images) {
                foreach ($gallery->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $gallery->delete();
            
            return $this->successResponse(null, 'Galería eliminada correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Galería');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la galería', 500);
        }
    }

    /**
     * Add images to an existing gallery.
     */
    public function addImages(Request $request, string $id): JsonResponse
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            $validated = $request->validate([
                'images' => 'required|array|min:1',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $currentImages = $gallery->images ?? [];
            
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('galleries', 'public');
            }
            
            $gallery->update(['images' => $currentImages]);

            return $this->successResponse($gallery, 'Imágenes agregadas correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Galería');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al agregar las imágenes', 500);
        }
    }

    /**
     * Reorder images in a gallery.
     */
    public function reorderImages(Request $request, string $id): JsonResponse
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            $validated = $request->validate([
                'images' => 'required|array',
                'images.*' => 'string', // Image paths in new order
            ]);

            $gallery->update(['images' => $validated['images']]);

            return $this->successResponse($gallery, 'Imágenes reordenadas correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Galería');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al reordenar las imágenes', 500);
        }
    }
}