<x-mail::message>
# Nuevo comentario en la noticia

**Noticia:** {{ $news->title }}

**Autor del comentario:** {{ $comment->name }}

**Comentario:**
{{ $comment->content }}

<x-mail::button :url="url('/admin/comments')">
Revisar comentarios
</x-mail::button>

Gracias,<br>
Radio Stereo Umachiri
</x-mail::message>
