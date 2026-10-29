<?php

namespace App\Http\Controllers\Admin;

use App\Models\Podcast;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PodcastApiController extends BaseApiController
{
    /**
     * Display a listing of podcasts for a program.
     */
    public function index(Request $request, string $programId): JsonResponse
    {
        try {
            $program = Program::findOrFail($programId);
            $params = $this->getPaginationParams($request);
            
            $query = $program->podcasts();
            
            // Apply filters
            $searchableFields = ['title', 'description'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            $podcasts = $query->paginate($params['per_page']);
            
            return $this->paginatedResponse($podcasts, 'Podcasts obtenidos correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Programa');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener los podcasts', 500);
        }
    }

    /**
     * Store a newly created podcast.
     */
    public function store(Request $request, string $programId): JsonResponse
    {
        try {
            $program = Program::findOrFail($programId);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'audio_file' => 'required|file|mimes:mp3,wav,m4a|max:51200', // 50MB max
                'duration' => 'nullable|string',
                'published_at' => 'required|date',
            ]);

            $audioPath = null;
            if ($request->hasFile('audio_file')) {
                $audioPath = $request->file('audio_file')->store('podcasts', 'public');
            }

            $podcast = $program->podcasts()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'audio_file' => $audioPath,
                'duration' => $validated['duration'],
                'published_at' => $validated['published_at'],
            ]);

            return $this->successResponse($podcast, 'Podcast creado correctamente', 201);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Programa');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el podcast', 500);
        }
    }

    /**
     * Display the specified podcast.
     */
    public function show(string $programId, string $id): JsonResponse
    {
        try {
            $program = Program::findOrFail($programId);
            $podcast = $program->podcasts()->findOrFail($id);
            
            return $this->successResponse($podcast, 'Podcast obtenido correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Podcast');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el podcast', 500);
        }
    }

    /**
     * Update the specified podcast.
     */
    public function update(Request $request, string $programId, string $id): JsonResponse
    {
        try {
            $program = Program::findOrFail($programId);
            $podcast = $program->podcasts()->findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'audio_file' => 'nullable|file|mimes:mp3,wav,m4a|max:51200', // 50MB max
                'duration' => 'nullable|string',
                'published_at' => 'required|date',
                'remove_audio' => 'nullable|boolean',
            ]);

            // Handle audio removal
            if ($request->get('remove_audio')) {
                if ($podcast->audio_file) {
                    Storage::disk('public')->delete($podcast->audio_file);
                    $podcast->audio_file = null;
                }
            }

            // Handle new audio upload
            if ($request->hasFile('audio_file')) {
                if ($podcast->audio_file) {
                    Storage::disk('public')->delete($podcast->audio_file);
                }
                $audioPath = $request->file('audio_file')->store('podcasts', 'public');
                $podcast->audio_file = $audioPath;
            }

            $podcast->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'duration' => $validated['duration'],
                'published_at' => $validated['published_at'],
            ]);

            return $this->successResponse($podcast, 'Podcast actualizado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Podcast');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el podcast', 500);
        }
    }

    /**
     * Remove the specified podcast.
     */
    public function destroy(string $programId, string $id): JsonResponse
    {
        try {
            $program = Program::findOrFail($programId);
            $podcast = $program->podcasts()->findOrFail($id);
            
            // Delete associated audio file
            if ($podcast->audio_file) {
                Storage::disk('public')->delete($podcast->audio_file);
            }
            
            $podcast->delete();
            
            return $this->successResponse(null, 'Podcast eliminado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Podcast');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el podcast', 500);
        }
    }
}