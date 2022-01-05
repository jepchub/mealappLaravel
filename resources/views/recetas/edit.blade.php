@extends('layouts.app')
{{-- 1.2.1 --}}
@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section( 'botones')
  <a href="{{ route('recetas.index') }}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Volver
  </a>
@endsection

@section('content')
<h2 class="text-center mb-5" > Editar Receta: {{ $receta->titulo }} </h2>

{{-- {{$receta}} --}}

<div class="row justify-content-center mt-5">
  <div class="col-md-8">
    <form method="POST" action="{{ route('recetas.update', ['receta' => $receta->id]) }}" enctype="multipart/form-data" novalidate>
      @csrf
      @method('PUT')
      <div class="form-group">
        <label for="titulo">Titulo Receta</label>

        <input type="text"
            name="titulo"
            class="form-control bg-prima @error('titulo') is-invalid @enderror "
            id="titulo"
            placeholder="Titulo Receta"
            value="{{ $receta->titulo }}"
        />

        @error('titulo')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
{{-- Categoria --}}
      <div class="from-group">
        <label for="categoria">Categoria</label>

        <select
          name="categoria"
          class="form-control @error('categoria') is-invalid @enderror"
          id="categoria"
        >
          <option value="">-- Seleccione --</option>
          @foreach($categorias as $categoria)
            <option
              value="{{ $categoria->id }}"
              {{ $receta->categoria_id == $categoria->id ? 'selected' : '' }}
          >{{$categoria->nombre}}</option>
          @endforeach
        </select>

        @error('categoria')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

{{-- Ingredientes --}}
      <div class="form-group mt-3">
        <label for="ingredientes">Ingredientes</label>
        <input id="ingredientes" type="hidden" name="ingredientes" value="{{ $receta->ingredientes }}">
        <trix-editor
          class="form-control @error('ingredientes') is-invalid @enderror"
          input="ingredientes"
        ></trix-editor>

        @error('ingredientes')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

{{-- preparacion --}}
      <div class="form-group mt-3">
        <label for="preparacion">Preparación</label>
        <input id="preparacion" type="hidden" name="preparacion" value="{{ $receta->preparacion }}">

        <trix-editor
          class="form-control @error('preparacion') is-invalid @enderror"
          input="preparacion"></trix-editor>

        @error('preparacion')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>
{{-- Cargar imagen --}}
      <div class="form-group mt-3">
        <label for="imagen"><strong>Elige la imagen</strong></label>

        <input
          id="imagen"
          type="file"
          class="form-control @error('imagen') is-invalid @enderror"
          name="imagen"
        >

        <div class="mt-4">
          <p>Imagen Actual:</p>
          <img src="/storage/{{$receta->imagen}}" style="width: 300px">
        </div>

        @error('imagen')
          <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

{{-- Agregar Receta --}}
      <div class="form-group" >
        <input type="submit" class="btn btn-primary" value="Agregar Receta" />
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix-core.js" integrity="sha512-H8CbNdhcOBCt62S6eVGAUSiyNx5OGVEVrYIIVs0iIgurgD1+oTA9THTZ1tqxSE9yw9vzfilg83xgyxD467a28g==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
@endsection