<div class="col-md-4 mt-4">
  <div class="card shadow">
    {{-- imagenes --}}
    <img class="card-img-top" src="/storage/{{$receta->imagen}}" alt="imagen receta">
    
    <div class="card-body">
      {{-- titulo --}}
      <h3 class="card-title">{{$receta->titulo}}</h3>
      {{-- fecha --}}
      <div class="meta-receta d-flex justify-content-between">
        @php
          $fecha = $receta->created_at
        @endphp
        <p class="text-primary fecha font-weight-bold">
          <fecha-receta fecha="{{$fecha}}"></fecha-receta>
        </p>

        <p>{{count($receta->likes)}} <svg class="icono text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg></p>
      </div>
      <p>{{Str::words(strip_tags($receta->preparacion), 20)}}</p>
      <a href="{{route('recetas.show', ['receta' => $receta->id])}}"
        class="btn btn-outline-success d-block font-weight-bold"
      >Ver Receta</a>
    </div>
    
  </div>
</div>