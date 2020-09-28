@extends('app')

@section('css')
@endsection

@section('content')

<h4 class="mt-3">Edición de producto con CÓDIGO INTERNO {{ $product->code }}</h4><br>

<div class="row justify-content-center mt-3">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover data-table display">
						<thead>
							<tr>
								<th>Código</th>
								<th>Nombre</th>
								<th>Categorías</th>
								<th>Variantes</th>
								<th>Tipo</th>
								<th>Stock</th>
								<th>Precio</th>
								<th>Mostrar en tienda</th>
								<th class="td-max-30">Detalle</th>
								<th class="td-max-20">Proveedor</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $product->code }}</td>
								<td>{{ $product->name }}</td>
								<td>{{ $product->getCategory() }}</td>
								<td>{{ $product->getVariant() }}</td>
								<td>{{ $product->type }}</td>
								<td>{{ $product->stock }}</td>
								<td>${{ $product->price }}</td>
								<td>{{ $product->showOnStore?'SI':'NO' }}</td>
								<td class="td-max-30">{{ $product->details }}</td>
								<td class="td-max-20">{{ $product->vendor }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<form method="POST" action="/products/{{ $product->id }}" id="products" class="mt-3">
	@csrf
	<input hidden name="id" id="id" value="{{ $product->id }}" /><br>
	<h5>Seleccione la variante y la categoría adecuada para el presente producto</h5><br>

	<label>Mostrar en Tienda</label>
	<input type="checkbox" name="showOnStore" id="showOnStore" {{ $product->showOnStore?'checked':'' }}/>
	<br>
	<label>Variante</label>
	<select name="variant_id">
		<option value="0" selected>Sin Variantes</option>
		@foreach($variants as $key => $variant)
		<option value="{{ $variant->id }}" {{ ($product->variant_id != null && $variant->id == $product->variant_id)?'selected':''}}>{{ 'ID '.$variant->id }}{{': '.$variant->variants }}</option>
		@endforeach
	</select>
	<br>
	<label>Categoría</label>
	<select name="category_id" style="min-width: 400px">
		@foreach($categories as $key => $category)
		<option value="{{ $category['id'] }}" {{ ($product->categories()->first() != null && $product->categories()->first()->id == $category['id'])?'selected':''}} {{ $category['disabled'] === true?'disabled':'' }}>{{ $category['name'] }}</option>
		@endforeach
	</select>
	<br>
	
	<button type="submit">GUARDAR</button>
</form>

@endsection

@section('script')

@endsection