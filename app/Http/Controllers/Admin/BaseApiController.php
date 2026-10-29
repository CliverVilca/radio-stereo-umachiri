<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BaseApiController extends Controller
{
    /**
     * Return a success JSON response.
     */
    protected function successResponse($data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Return an error JSON response.
     */
    protected function errorResponse(string $message = 'Error', int $status = 400, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * Return a validation error response.
     */
    protected function validationErrorResponse(ValidationException $exception): JsonResponse
    {
        return $this->errorResponse(
            'Error de validación',
            422,
            $exception->errors()
        );
    }

    /**
     * Return a not found error response.
     */
    protected function notFoundResponse(string $resource = 'Recurso'): JsonResponse
    {
        return $this->errorResponse(
            "{$resource} no encontrado",
            404
        );
    }

    /**
     * Return an unauthorized error response.
     */
    protected function unauthorizedResponse(string $message = 'No autorizado'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a forbidden error response.
     */
    protected function forbiddenResponse(string $message = 'Acceso denegado'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Handle pagination for API responses.
     */
    protected function paginatedResponse($paginator, string $message = 'Datos obtenidos correctamente'): JsonResponse
    {
        return $this->successResponse([
            'items' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'has_more_pages' => $paginator->hasMorePages(),
            ]
        ], $message);
    }

    /**
     * Get pagination parameters from request.
     */
    protected function getPaginationParams(Request $request): array
    {
        return [
            'page' => $request->get('page', 1),
            'per_page' => min($request->get('per_page', 10), 100), // Max 100 items per page
            'search' => $request->get('search'),
            'sort_by' => $request->get('sort_by', 'created_at'),
            'sort_order' => $request->get('sort_order', 'desc'),
        ];
    }

    /**
     * Apply search and sorting to query.
     */
    protected function applyFilters($query, array $params, array $searchableFields = [])
    {
        // Apply search
        if (!empty($params['search']) && !empty($searchableFields)) {
            $search = $params['search'];
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$search}%");
                }
            });
        }

        // Apply sorting
        if (!empty($params['sort_by'])) {
            $sortOrder = in_array(strtolower($params['sort_order']), ['asc', 'desc']) 
                ? $params['sort_order'] 
                : 'desc';
            $query->orderBy($params['sort_by'], $sortOrder);
        }

        return $query;
    }
}