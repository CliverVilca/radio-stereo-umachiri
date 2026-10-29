<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = \App\Models\Comment::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function approve($id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->approved = true;
        $comment->save();
        return redirect()->route('admin.comments.index')->with('success', 'Comentario aprobado.');
    }

    public function destroy($id)
    {
        $comment = \App\Models\Comment::findOrFail($id);
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Comentario eliminado.');
    }
}
