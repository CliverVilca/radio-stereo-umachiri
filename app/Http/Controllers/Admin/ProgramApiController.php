<?php

namespace App\Http\Controllers\Admin;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProgramApiController extends BaseApiController
{
    /**
     * Display a listing of programs.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = Program::query();
            
            // Apply filters
            $searchableFields = ['title', 'description', 'host'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            // Filter by featured if provided
            if ($request->has('is_featured')) {
                $query->where('is_featured', $request->boolean('is_featured'));
            }
            
            $programs = $query->paginate($params['per_page']);
            
            return $this->paginatedResponse($programs, 'Programas obtenidos correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener los programas', 500);
        }
    }

    /**
     * Store a newly created program.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'host' => 'required|string|max:255',
                'days_of_week' => 'required|array',
                'days_of_week.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_featured' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('programs', 'public');
            }

            $program = Program::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'host' => $validated['host'],
                'days_of_week' => json_encode($validated['days_of_week']),
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'is_featured' => $validated['is_featured'] ?? false,
                'image' => $imagePath,
            ]);

            return $this->successResponse($program, 'Programa creado correctamente', 201);
            
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el programa', 500);
        }
    }

    /**
     * Display the specified program.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $program = Program::findOrFail($id);
            return $this->successResponse($program, 'Programa obtenido correctamente');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Programa');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el programa', 500);
        }
    }

    /**
     * Update the specified program.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $program = Program::findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'host' => 'required|string|max:255',
                'days_of_week' => 'required|array',
                'days_of_week.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'is_featured' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_image' => 'nullable|boolean',
            ]);

            // Handle image removal
            if ($request->get('remove_image')) {
                if ($program->image) {
                    Storage::disk('public')->delete($program->image);
                    $program->image = null;
                }
            }

            // Handle new image upload
            if ($request->hasFile('image')) {
                if ($program->image) {
                    Storage::disk('public')->delete($program->image);
                }
                $imagePath = $request->file('image')->store('programs', 'public');
                $program->image = $imagePath;
            }

            $program->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'host' => $validated['host'],
                'days_of_week' => json_encode($validated['days_of_week']),
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'is_featured' => $validated['is_featured'] ?? false,
            ]);

            return $this->successResponse($program, 'Programa actualizado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Programa');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el programa', 500);
        }
    }

    /**
     * Remove the specified program.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $program = Program::findOrFail($id);
            
            // Delete associated image
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            
            $program->delete();
            
            return $this->successResponse(null, 'Programa eliminado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Programa');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el programa', 500);
        }
    }
}