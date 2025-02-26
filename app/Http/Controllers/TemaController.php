<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\NivelEducativo;
use App\Models\Tema;
use Inertia\Inertia;

class TemaController extends Controller
{

    public function index(Request $request) {}
    public function store(Request $request)
    {
        $request->validate([
            'nombreTema' => 'required|string|max:255',
            'descripcionTema' => 'nullable|string',
            'imagenTema' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'numUsuarios' => 'required|integer|min:0',
            'likes' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'idCategoria' => 'required|exists:categorias,idCategoria',
            'idNivel' => 'required|exists:nivel_educativos,idNivel',
            'horasContenido' => 'required|integer|min:0',
            'idioma' => 'required|string|max:255',
            'certificado' => 'required|boolean',
        ]);

        // Guardar la imagen en storage
        $imagenPath = $request->file('imagenTema')->store('temas', 'public');
        $imagenUrl = asset('storage/' . $imagenPath);

        // Crear el tema
        $tema = Tema::create([
            'nombreTema' => $request->nombreTema,
            'descripcionTema' => $request->descripcionTema,
            'imagenTema' => $imagenUrl,
            'numUsuarios' => $request->numUsuarios,
            'likes' => $request->likes,
            'precio' => $request->precio,
            'idCategoria' => $request->idCategoria,
            'idNivel' => $request->idNivel,
            'horasContenido' => $request->horasContenido,
            'fechaUltimaActualizacion' => NOW(),
            'idioma' => $request->idioma,
            'certificado' => $request->certificado,
        ]);
        return response()->json(['tema' => $tema], 201);
    }
}
