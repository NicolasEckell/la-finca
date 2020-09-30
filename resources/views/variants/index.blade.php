@extends('app')

@section('css')
@endsection

@section('content')

<div class="row justify-content-center mt-3">
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-header">
				<a class="badge badge-outline-primary badge-button" href="/variants/create">
					Crear Nueva Variante
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover data-table display">
						<thead>
							<tr>
								<th>ID</th>
								<th>Variantes</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($variants as $variant)
							<tr>
								<td>{{ $variant->id }}</td>
								<td>{{ $variant->variants }}</td>
								<td>
									<a class="badge badge-outline-info badge-button" href="/variants/{{ $variant->id }}/edit">
										Editar Variante
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

@endsection