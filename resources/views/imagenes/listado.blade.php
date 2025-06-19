@foreach ($imagenes as $imagen)
    <img src="{{ asset($imagen->url) }}" alt="Imagen" class="w-32 h-32 object-cover rounded">
@endforeach
