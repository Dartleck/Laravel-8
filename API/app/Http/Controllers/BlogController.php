<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // Mostrar todos los blogs
    public function index()
{
    $blogs = Blog::with('user')->get(); // Obtener todos los blogs junto con los datos del usuario que los creó
    return response()->json($blogs);
}


    // Crear un nuevo blog
    public function store(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    // Verificar si el usuario está autenticado
    if (!Auth::check()) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    // Crear el nuevo blog asociado al usuario autenticado
    $blog = Blog::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => Auth::id(), // Relacionar el blog con el usuario autenticado
    ]);

    return response()->json($blog, 201);
}

    


    // Editar un blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
    
        // Verificar si el usuario es el propietario del blog
        if ($blog->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tienes permiso para editar este blog'], 403);
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        $blog->update($request->only(['title', 'content']));
    
        return response()->json($blog);
    }
    

    // Eliminar un blog
    public function destroy($id)
{
    $blog = Blog::findOrFail($id);

    // Verificar si el usuario es el propietario del blog
    if ($blog->user_id !== Auth::id()) {
        return response()->json(['error' => 'No tienes permiso para eliminar este blog'], 403);
    }

    $blog->delete();

    return response()->json(['message' => 'Blog eliminado correctamente']);
}

}
