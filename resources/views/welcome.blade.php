@extends('app')

@section('content')

<div class="container-fluid">

	<div class="d-flex justify-content-center mt-1">
		<span class="badge badge-outline-primary badge-button">
			La Finca - Importación
		</span>
	</div>

	@include('picker')

	<div class='btn btn-success mt-5'>
		<a href="exportar">GENERAR CSV PARA TIENDANUBE</a>
	</div>

</div>

@endsection

@section('script')

@endsection