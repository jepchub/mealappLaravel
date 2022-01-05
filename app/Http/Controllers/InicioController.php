<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    // Pagina principañ
    public function index(){

        // Mostrar las recetas por cantidad de votos
        // $votadas = Receta::has('likes', '>', 0)->get();
        $votadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->take(3)->get();
        // obtener las recetas mas nuevas
        // $nuevas = Receta::orderBy('created_at', 'DESC')->get();
        // $nuevas = Receta::latest()->get();
        // $nuevas = Receta::latest()->limit(5)->get();
        $nuevas = Receta::latest()->take(6)->get();
        // return $nuevas;//retorna las recetas mas nuevas

        // Obtener todas las cateogrias
        $categorias = CategoriaReceta::all();

        // Recetas por categoria
        // $mexicana = Receta::where('categoria_id', 1)->get();
        // $argentina = Receta::where('categoria_id', 2)->get();
        // return $mexicana;
        // return view('inicio.index', compact('nuevas', 'mexicana', 'argentina'));
        
        // Agrupar las recetas por categoria
        $recetas = [];
        foreach($categorias as $categoria) {
            $recetas[Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id)->take(3)->get();
        };
        return view('inicio.index', compact('nuevas', 'recetas', 'votadas'));
    }
}
