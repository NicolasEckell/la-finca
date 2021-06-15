@extends('app')

@section('css')
@endsection

@section('content')

<div class="row justify-content-center mt-3">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover data-table display">
						<thead>
							<tr>
								<th>Acciones</th>
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
							@foreach($products as $product)
							<tr>
								<td>
									<a class="btn btn-outline-info badge-button" href="/products/{!! $product->id !!}">
										Editar Producto
									</a>
								</td>
								<td>{!! $product->code !!}</td>
								<td>{!! $product->name !!}</td>
								<td>{!! $product->showCategories() !!}</td>
								<td>{!! $product->getVariant() !!}</td>
								<td>{!! $product->type !!}</td>
								<td>{!! $product->stock !!}</td>
								<td>${!! $product->price !!}</td>
								<td>{!! $product->showOnStore?'SI':'NO' !!}</td>
								<td class="td-max-30">{!! $product->details !!}</td>
								<td class="td-max-20">{!! $product->vendor !!}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

<script src="{!! asset('js/data-table.js') !!}"></script>

@endsection
