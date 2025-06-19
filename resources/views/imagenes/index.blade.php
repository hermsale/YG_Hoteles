@extends('layouts.app')

@section('content')
    <h1>Listado de Imágenes</h1>
    @include('imagenes.listado', ['imagenes' => $imagenes])
@endsection
