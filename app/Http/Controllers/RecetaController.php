<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

// ------- INDEX
    public function index()
    {
        // auth()->user()->recetas->dd();//trae todas las recetas de cada usuario
        // Auth::user()->recetas->dd(); //trae el contenido como un json

        // $usuario = auth()->user();//ya existe en el template de blade
        // $recetas = auth()->user()->recetas;
        // $recetas = auth()->user()->recetas->paginate(2);

        // $usuario = auth()->user()->id;
        $usuario = auth()->user();

        // $meGusta = auth()->user()->meGusta;

        // Receta con paginacion
        $recetas = Receta::where('user_id', $usuario->id)->paginate(10);

        return view('recetas.index')
            ->with('recetas',$recetas)
            ->with('usuario',$usuario);
            // ->with('usuario', $usuario);//ya existe en los templates de blade
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::table('categoria_receta')->get()->dd(); trae todo
        // DB::table('categoria_receta')->get()->pluck('nombre','id')->dd();

        // Obtener las categorias (sin modelo)
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre','id');

        // Obtener las catergorias con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd( $request->all() );
        // dd( $request['imagen']->store('upload-recetas', 'public') );
        // Validacion
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image',
        ]);

        // Obtiene la ruta de la imagen
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

         // Resize de la imagen
         $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
         $img->save();

        // almacenar en la BD (sin modelo)
        // DB::table('recetas')->insert([
        //     'titulo' => $data['titulo'],
        //     'preparacion' => $data['preparacion'],
        //     'ingredientes' => $data['ingredientes'],
        //     'imagen' => $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria'],
        // ]);

        // almacenar en la DB (con modelo)
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' => $ruta_imagen,
            'categoria_id' => $data['categoria'],
        ]);

        // Redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        // si tiene (Receta $receta) devuelve toda la informacion del usuario
        // ($receta) solo devuelve el id de la receta
        // metodos para obtener una receta
        // $receta = Receta::find($receta);//busca la receta por el id
        // $receta = Receta::findOrFail($receta);//=al anterior solo que muestra una vista de 404 not found
        // return $receta;

        // Obtener si el usuario actual le gusta la recceta y esta autenticado
        $like = (auth()->user()) ? auth()->user()->meGusta->contains($receta->id) : false;

        // Pasa la cantidad de likes a la vista
        $likes = $receta->likes->count();

        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        // Revisar el policy
        $this->authorize('view', $receta);
        // Con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        // Revisar el policy
        $this->authorize('update', $receta);
        // Validacion
        $data = $request->validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
        ]);
        // Asignar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        // Si el usuario sube una nueva imagen
        if(request('imagen')){
            // Obtiene la ruta de la imagen
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

            // Resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $img->save();

            // Asignar el objeto
            $receta->imagen = $ruta_imagen;
        }
        $receta->save();

        // Redireccionar
        return redirect()->action('RecetaController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        //Ejecutar el policy
        $this->authorize('delete', $receta);

        //Eliminar la receta
        $receta->delete();

        return redirect()->action('RecetaController@index');
    }

    public function search(Request $request)
    {
        // $busqueda = $request['buscar'];
        $busqueda = $request->get('buscar');
        // return $busqueda;
        $recetas = Receta::where('titulo', 'like', '%'.$busqueda.'%')->paginate(10);
        $recetas->appends(['buscar'=> $busqueda]);

        return view('busquedas.show', compact('recetas', 'busqueda'));
    }
}
