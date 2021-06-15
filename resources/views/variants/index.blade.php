@extends('app')

@section('css')
@endsection

@section('content')


    <div class="row justify-content-center mt-3">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    @include('flash::message')
                    <a class="btn btn-outline-primary badge-button" href="/variants/create">
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
                                    <th>Productos asociados</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $variant)
                                    <tr>
                                        <td>{!! $variant->id !!}</td>
                                        <td>{!! $variant->variants !!}</td>
                                        <td>{!! count($variant->products()) !!}</td>
                                        <td>
                                            <a class="btn btn-outline-info" href="/variants/{!! $variant->id !!}">
                                                Editar Variante
                                            </a>
                                            <a class="btn btn-outline-danger" href="/variants/{!! $variant->id . '/delete' !!}">
                                                Borrar Variante
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
