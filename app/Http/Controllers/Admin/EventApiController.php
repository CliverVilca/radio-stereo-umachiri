<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EventApiController extends BaseApiController
{
    /**
     * Display a listing of events.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = Event::query();
            
            // Apply filters
            $searchableFields = ['title', 'description', 'location'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            // Filter by date range if provided
            if ($request->has('start_date')) {
                $query->where('event_date', '>=', $request->get('start_date'));
            }
            
            if ($request->has('end_date')) {
                $query->where('event_date', '<=', $request->get('end_date'));
            }
            
            // Filter by upcoming events
            if ($request->boolean('upcoming_only')) {
                $query->where('event_date', '>=', now());
            }
            
            $events = $query->paginate($params['per_page']);
            
            return $this->paginatedResponse($events, 'Eventos obtenidos correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener los eventos', 500);
        }
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'event_date' => 'required|date|after_or_equal:today',
                'event_time' => 'required|date_format:H:i',
                'location' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_featured' => 'nullable|boolean',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('events', 'public');
            }

            $event = Event::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'location' => $validated['location'],
                'image' => $imagePath,
                'is_featured' => $request->boolean('is_featured'),
            ]);

            return $this->successResponse($event, 'Evento creado correctamente', 201);
            
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el evento', 500);
        }
    }

    /**
     * Display the specified event.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            return $this->successResponse($event, 'Evento obtenido correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Evento');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el evento', 500);
        }
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'event_date' => 'required|date',
                'event_time' => 'required|date_format:H:i',
                'location' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_featured' => 'nullable|boolean',
                'remove_image' => 'nullable|boolean',
            ]);

            // Handle image removal
            if ($request->get('remove_image')) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                    $event->image = null;
                }
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $imagePath = $request->file('image')->store('events', 'public');
                $event->image = $imagePath;
            }

            $event->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'],
                'location' => $validated['location'],
                'is_featured' => $request->boolean('is_featured'),
            ]);

            return $this->successResponse($event, 'Evento actualizado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Evento');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el evento', 500);
        }
    }

    /**
     * Remove the specified event.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            
            // Delete associated image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $event->delete();
            
            return $this->successResponse(null, 'Evento eliminado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Evento');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el evento', 500);
        }
    }
}