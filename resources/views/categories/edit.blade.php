@extends('app')

@section('css')
@endsection

@section('content')

<h4 class="mt-3">Editar Categoria existente</h4><br>

<form method="POST" action="/categories" id="categories">
	@csrf
	<h5>Solo se puede editar el nombre de la categoría</h5><br>
	<label>Nombre de la categoría</label>
	<input required type="text" name="name" id="name" value="{{ $category->name }}" />
	<br>
	<button class="btn btn-primary" type="submit">
		<span style="color: white">
		AGREGAR</span>
	</button>
	<input hidden name="id" id="id" value="{{ $category->id }}" />
</form>

@endsection

@section('script')
@endsection