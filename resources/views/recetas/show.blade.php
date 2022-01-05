@extends('layouts.app')

{{-- @section( 'botones')
  <a href="{{ route('inicio.index') }}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Volver
  </a>
@endsection --}}

@section('content')

  {{-- <h1>{{ $receta }}</h1> --}}

  <article class="contenido-receta bg-white p-5 shadow">
{{-- Titulo --}}
    <h1 class="text-center mb-4">{{ $receta->titulo }}</h1>

{{-- Imagen --}}
    <div class="imagen-receta">
      <img src="/storage/{{ $receta->imagen }}" alt="{{ $receta->titulo }}" class="w-100">
    </div>

{{-- Categoria  --}}
    <div class="receta-meta mt-3">
      <p>
        <span class="font-weight-bold text-primary">Escrito en:</span>
        <a class="text-dark" href="{{route('categorias.show', ['categoriaReceta' => $receta->categoria->id])}}">
          {{ $receta->categoria->nombre}}
        </a>
      </p>

{{-- Autor --}}
      <p>
        <span class="font-weight-bold text-primary">Autor:</span>
        <a class="text-dark" href="{{route('perfiles.show', ['perfil' => $receta->autor->id])}}">
        {{ $receta->autor->name }}
        </a>
      </p>

{{-- Fecha de creacion de la receta--}}
      <p>
        <span class="font-weight-bold text-primary">Fecha:</span>

        @php
          $fecha = $receta->created_at
        @endphp

        <fecha-receta fecha="{{ $fecha }}" ></fecha-receta>
      </p>

{{-- Ingredientes --}}
      <div class="ingredientes">
        <h2 class="my-3 text-primary">Ingredientes</h2>

        {!! $receta->ingredientes !!}
      </div>

{{-- Preparacion --}}
      <div class="preparacion">
        <h2 class="my-3 text-primary">Preparacion</h2>

        {!! $receta->preparacion !!}
      </div>

      <div class="justify-content-center row text-center">
        <like-button
          receta-id="{{$receta->id}}"
          like="{{$like}}"
          likes="{{$likes}}"
        ></like-button>
      </div>

    </div>
  </article>
@endsection