@extends('layouts.app')

@section( 'botones')
  @include('ui.navegacion')
@endsection

@section('content')
<h2 class="text-center mb-5" >Administra tus recetas </h2>

<div class="col-md-10 mx-auto bg-white p-3">
  <table class="table">
    <thead class="bg-success text-light">
      <tr>
        <th scole="col">Titulo</th>
        <th scole="col">Categoria</th>
        <th scole="col">Acciones</th>
      </tr>
    </thead>
    {{-- Contenido dinamico de la tabla --}}
    <tbody>
      @foreach($recetas as $receta)
        <tr>
          <td>{{$receta->titulo}}</td>
          <td>{{$receta->categoria->nombre}}</td>
          <td>
            <a href="{{ route('recetas.show', ['receta' => $receta->id]) }}" class="btn btn-success d-block mb-2">Ver</a>
            <a href="{{ route('recetas.edit', ['receta' => $receta->id]) }}" class="btn btn-dark d-block mb-2">Editar</a>
            <eliminar-receta
              receta-id={{$receta->id}}
            ></eliminar-receta>
            {{-- <form action="{{ route('recetas.destroy', ['receta' => $receta->id]}}" method="POST" >
              @csrf
              @method('DELETE')
              <input type="submit" class="btn btn-danger d-block w-100 mb-2" value="Eliminar &times;">
            </form> --}}
            {{-- <a href="{{ action('RecetaController@show', ['receta' => $receta->id]) }}" class="btn btn-success">Ver</a> --}}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="col-12 mt-4 justify-content-center d-flex">
    {{ $recetas->links() }}
  </div>

  {{-- {{Auth::user()->meGusta}} --}}
  {{-- {{$usuario->meGusta}} --}}
  <h2 class="text-center my-5">Recetas que te gustan</h2>
  <div class="col-md-10 mx-auto bg-white p-3">

    @if(count($usuario->meGusta)>0)
      <ul class="list-group">
        @foreach($usuario->meGusta as $receta)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <p>{{$receta->titulo}}</p>
            <a
              class="btn btn-outline-success text-uppercase font-weight-bold"
              href="{{route('recetas.show', ['receta' => $receta->id])}}"
            >Ver</a>
          </li>
        @endforeach
      </ul>
    @else
      <p class="text-center">A??n no tienes recetas Guardadas...<small> Dale like a las recetas y aparecer??n aqu??...</p>
    @endif
    
  </div>
</div>
@endsection