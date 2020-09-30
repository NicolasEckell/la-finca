@extends('app')

@section('css')
@endsection

@section('content')

<h4 class="mt-3">Editar la variante ID {{ $variant->id }}</h4><br>

<form method="POST" action="/variants/{{ $variant->id }}" id="variants">
	@csrf
	<input hidden name="id" id="id" value="{{ $variant->id }}" /><br>
	<h5>Completa al menos dos campos para conformar una variante. El valor 1 debe ser menor que el valor 2, y así sucesivamente.</h5><br>
	@foreach($variant->variants as $key => $value)
	<label>Valor {{ $key+1 }}</label>
	<input required type="number" name="val_{{ $key }}" id="val_{{ $key }}" value="{{ $value }}" /><br>
	@endforeach
	@for ($i = $key+1; $i < 10; $i++)
	<label>Valor {{ $i+1 }}</label>
	<input required type="number" name="val_{{ $i }}" id="val_{{ $i }}" /><br>
	@endfor
	<a class="btn btn-primary" type="submit" onclick="return checkVar(event)">
		<span style="color: white">
			GUARDAR
		</span>
	</a>
</form>

@endsection

@section('script')

<script src="{{ asset('js/utils.js') }}"></script>

@endsection