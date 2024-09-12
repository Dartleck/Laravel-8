<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // Obtener todos los blogs
    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    // Crear un nuevo blog (solo para usuarios autenticados)
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'direccion_logo' => 'required|string'
        ]);

        $blog = Blog::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'direccion_logo' => $request->direccion_logo,
            'user_id' => auth()->id() // Relacionamos el blog con el usuario autenticado
        ]);

        return response()->json($blog);
    }
}
