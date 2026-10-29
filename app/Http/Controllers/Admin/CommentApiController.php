<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentApiController extends BaseApiController
{
    /**
     * Display a listing of comments.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $params = $this->getPaginationParams($request);
            
            $query = Comment::with(['news:id,title']);
            
            // Apply filters
            $searchableFields = ['author_name', 'author_email', 'content'];
            $query = $this->applyFilters($query, $params, $searchableFields);
            
            // Filter by status if provided
            if ($request->has('status')) {
                $query->where('status', $request->get('status'));
            }
            
            // Filter by news if provided
            if ($request->has('news_id')) {
                $query->where('news_id', $request->get('news_id'));
            }
            
            $comments = $query->paginate($params['per_page']);
            
            return $this->paginatedResponse($comments, 'Comentarios obtenidos correctamente');
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener los comentarios', 500);
        }
    }

    /**
     * Approve a comment.
     */
    public function approve(string $id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);
            
            $comment->update(['status' => 'approved']);
            
            return $this->successResponse($comment, 'Comentario aprobado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Comentario');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al aprobar el comentario', 500);
        }
    }

    /**
     * Reject a comment.
     */
    public function reject(string $id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);
            
            $comment->update(['status' => 'rejected']);
            
            return $this->successResponse($comment, 'Comentario rechazado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Comentario');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al rechazar el comentario', 500);
        }
    }

    /**
     * Bulk approve comments.
     */
    public function bulkApprove(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'comment_ids' => 'required|array',
                'comment_ids.*' => 'integer|exists:comments,id',
            ]);

            $updated = Comment::whereIn('id', $validated['comment_ids'])
                ->update(['status' => 'approved']);

            return $this->successResponse(
                ['updated_count' => $updated],
                "Se aprobaron {$updated} comentarios correctamente"
            );
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al aprobar los comentarios', 500);
        }
    }

    /**
     * Bulk reject comments.
     */
    public function bulkReject(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'comment_ids' => 'required|array',
                'comment_ids.*' => 'integer|exists:comments,id',
            ]);

            $updated = Comment::whereIn('id', $validated['comment_ids'])
                ->update(['status' => 'rejected']);

            return $this->successResponse(
                ['updated_count' => $updated],
                "Se rechazaron {$updated} comentarios correctamente"
            );
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al rechazar los comentarios', 500);
        }
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();
            
            return $this->successResponse(null, 'Comentario eliminado correctamente');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->notFoundResponse('Comentario');
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el comentario', 500);
        }
    }

    /**
     * Bulk delete comments.
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'comment_ids' => 'required|array',
                'comment_ids.*' => 'integer|exists:comments,id',
            ]);

            $deleted = Comment::whereIn('id', $validated['comment_ids'])->delete();

            return $this->successResponse(
                ['deleted_count' => $deleted],
                "Se eliminaron {$deleted} comentarios correctamente"
            );
            
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar los comentarios', 500);
        }
    }
}