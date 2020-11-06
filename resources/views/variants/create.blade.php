@extends('app')

@section('css')
@endsection

@section('content')

<h4 class="mt-3">Agregar nueva variante</h4><br>

<form method="POST" action="/variants" id="variants">
	@csrf
	<h5>Completa al menos dos campos para conformar una variante. El valor 1 debe ser menor que el valor 2, y así sucesivamente.</h5><br>
	@for ($i = 0; $i < 10; $i++)
	<label>Valor {{ $i+1 }}</label>
	<input type="number" name="val_{{ $i }}" id="val_{{ $i }}" /><br>
	@endfor
	<button class="btn btn-primary" type="submit" {{-- onclick="return checkVar(event)" --}}>
		<span style="color: white">
			AGREGAR
		</span>
	</button>
</form>

@endsection

@section('script')

{{-- <script src="{{ asset('js/utils.js') }}"></script> --}}

@endsection