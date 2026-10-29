<?php

namespace App\Http\Controllers\Admin;

use App\Models\DJ;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DJApiController extends BaseApiController
{
    /**
     * Display a listing of DJs.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = DJ::query();
            
            // Apply filters
            $searchableFields = ['name', 'bio', 'specialties'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            // Filter by status if provided
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
            
            // Filter by featured if provided
            if ($request->has('is_featured')) {
                $query->where('is_featured', $request->boolean('is_featured'));
            }
            
            $djs = $query->orderBy('name', 'asc')->paginate($params['per_page']);
            
            return $this->paginatedResponse($djs, 'DJs obtenidos correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener los DJs', 500);
        }
    }

    /**
     * Store a newly created DJ.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'specialties' => 'nullable|string',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'social_media' => 'nullable|json',
                'status' => 'required|in:active,inactive',
                'is_featured' => 'nullable|boolean',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('djs', 'public');
            }

            $dj = DJ::create([
                'name' => $validated['name'],
                'bio' => $validated['bio'],
                'specialties' => $validated['specialties'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'social_media' => $validated['social_media'] ? json_decode($validated['social_media'], true) : null,
                'status' => $validated['status'],
                'is_featured' => $request->boolean('is_featured'),
                'photo' => $photoPath,
            ]);

            return $this->successResponse($dj, 'DJ creado correctamente', 201);
            
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el DJ', 500);
        }
    }

    /**
     * Display the specified DJ.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $dj = DJ::findOrFail($id);
            return $this->successResponse($dj, 'DJ obtenido correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('DJ');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el DJ', 500);
        }
    }

    /**
     * Update the specified DJ.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $dj = DJ::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'specialties' => 'nullable|string',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'social_media' => 'nullable|json',
                'status' => 'required|in:active,inactive',
                'is_featured' => 'nullable|boolean',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_photo' => 'nullable|boolean',
            ]);

            // Handle photo removal
            if ($request->get('remove_photo')) {
                if ($dj->photo) {
                    Storage::disk('public')->delete($dj->photo);
                    $dj->photo = null;
                }
            }

            // Handle new photo upload
            if ($request->hasFile('photo')) {
                if ($dj->photo) {
                    Storage::disk('public')->delete($dj->photo);
                }
                $photoPath = $request->file('photo')->store('djs', 'public');
                $dj->photo = $photoPath;
            }

            $dj->update([
                'name' => $validated['name'],
                'bio' => $validated['bio'],
                'specialties' => $validated['specialties'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'social_media' => $validated['social_media'] ? json_decode($validated['social_media'], true) : $dj->social_media,
                'status' => $validated['status'],
                'is_featured' => $request->boolean('is_featured'),
            ]);

            return $this->successResponse($dj, 'DJ actualizado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('DJ');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el DJ', 500);
        }
    }

    /**
     * Remove the specified DJ.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $dj = DJ::findOrFail($id);
            
            // Delete associated photo
            if ($dj->photo) {
                Storage::disk('public')->delete($dj->photo);
            }
            
            $dj->delete();
            
            return $this->successResponse(null, 'DJ eliminado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('DJ');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el DJ', 500);
        }
    }
}