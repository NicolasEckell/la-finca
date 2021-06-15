@extends('app')

@section('css')
    <style>
        label {
            margin-bottom: 0;
            margin-right: 5px;
        }

    </style>
@endsection

@section('content')

    <h4 class="mt-3">Editar la variante ID {!! $variant->id !!}</h4>
    <form method="POST" action="/variants/{!! $variant->id !!}}" id="variants">
        @csrf
        <input hidden name="id" id="id" value="{!! $variant->id !!}" />
        <h5>
            Completa al menos dos campos para conformar una variante. El valor 1 debe ser menor que el valor 2, y así
            sucesivamente.
        </h5>
        <div class="row justify-content-center">
            <div class="col-sm-12">
                @foreach ($variant->variants as $key => $value)
                    <div class="row justify-content-center align-items-center mt-1">
                        <label>Valor {!! $key + 1 !!}</label>
                        <input type="number" name="val_{!! $key !!}" id="val_{!! $key !!}"
                            value="{!! $value !!}" {!! ($key == 0 || $key == 1) ? 'required' : '' !!} />
                    </div>
                @endforeach
                @for ($i = $key + 1; $i < 10; $i++)
                    <div class="row justify-content-center align-items-center mt-1">
                        <label>Valor {!! $i + 1 !!}</label>
                        <input type="number" name="val_{!! $i !!}" id="val_{!! $i !!}"
                            {!! $i == 0 || $i == 1 ? 'required' : '' !!} />
                    </div>
                @endfor
            </div>
            <button class="btn btn-warning mt-3" type="submit" {{-- onclick="return checkVar(event)" --}}>
                <span style="color: white">
                    EDITAR
                </span>
            </button>
        </div>
        </div>
    </form>

@endsection

@section('script')

    {{-- <script src="{!! asset('js/utils.js') !!}"></script> --}}

@endsection
