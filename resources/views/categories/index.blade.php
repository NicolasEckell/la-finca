@extends('app')

@section('css')
@endsection

@section('content')
<div class="row justify-content-center mt-3">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-header">
				@include('flash::message')
				<a class="btn btn-outline-primary badge-button" href="/categories/create">
					Crear Nueva Categoria
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover data-table display">
						<thead>
							<tr>
								<th>Nº</th>
								<th>Nombre</th>
								<th>Cantidad de productos asociados</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($categories as $key => $category)
							<tr>
								<td>{!! $key+1 !!}</td>
								<td style="{!! ($category->parent_id == null)?'background-color: darkorange':''!!}">
									{!! $category->getFormatted() !!}
								</td>
								<th>{!! count($category->products) !!}</th>
								<td>
									<a class="btn btn-outline-primary badge-button" href="/categories/{!! $category->id !!}/products">
										Ver productos
									</a>
									<a class="btn btn-outline-info badge-button" href="/categories/{!! $category->id !!}">
										Editar Categoria
									</a>
									<a class="btn btn-outline-danger badge-button" onclick="return confirm('{!!'Desea eliminar la categoría '.$category->getFormatted().'?' !!}')" href="/categories/{!! $category->id !!}/delete">
										Eliminar Categoria
									</a>
								</td>
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
