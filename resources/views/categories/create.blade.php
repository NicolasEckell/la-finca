@extends('app')

@section('css')
@endsection

@section('content')

<h4 class="mt-3">Agregar Nueva Categoria</h4><br>

<form method="POST" action="/categories" id="categories">
	@csrf
	<h5>Puedes agregar una nueva categoría raíz (sin padre) o puedes crear una subcategoría apartir de otra existente (con padre)</h5><br>
	<label>Nombre para la nueva categoría</label>
	<input required type="text" name="name" id="name" />
	<br>
	<label>Categoría Padre (opcional)</label>
	<select name="parent_id">
		<option value="0" selected>Nueva Categoría Raíz</option>
		@foreach($categories as $key => $category)
		<option value="{{ $category->id }}">{{$category->getFormatted() }}</option>
		@endforeach
	</select>
	<br>
	<a class="btn btn-primary" type="submit">
		<span style="color: white">
			AGREGAR
		</span>
	</a>
</form>

@endsection

@section('script')
@endsection