@extends('app')

@section('css')
    <style>
        label {
            display: block;
        }

        select {
            margin-right: 5px;
            max-width: 100%;
        }

    </style>
@endsection

@section('content')

    <h4 class="mt-3">Edición de producto con CÓDIGO INTERNO {!! $product->code !!}</h4><br>

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
                                    <td>{!! $product->code !!}</td>
                                    <td>{!! $product->name !!}</td>
                                    <td>{!! $product->showCategories() !!}</td>
                                    <td>{!! $product->getVariant() !!}</td>
                                    <td>{!! $product->type !!}</td>
                                    <td>{!! $product->stock !!}</td>
                                    <td>${!! $product->price !!}</td>
                                    <td>{!! $product->showOnStore ? 'SI' : 'NO' !!}</td>
                                    <td class="td-max-30">{!! $product->details !!}</td>
                                    <td class="td-max-20">{!! $product->vendor !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="/products/{!! $product->id !!}" id="products" class="mt-3">
        @csrf
        <label>Mostrar en Tienda</label>
        <input type="checkbox" name="showOnStore" id="showOnStore" {!! $product->showOnStore ? 'checked' : '' !!} />

        <input hidden name="id" id="id" value="{!! $product->id !!}" /><br>
        <h5>Seleccione la variante y las categorías para el presente producto</h5><br>

        <div class="container">
            <div class="row justify-content-between align-items-start">
                <div class="col-md-6">
                    <label>Variante</label>
                    <select name="variant_id">
                        <option value="0" selected>Sin Variantes</option>
                        @foreach ($variants as $key => $variant)
                            <option value="{!! $variant->id !!}"
                                {!! $product->variant_id != null && $variant->id == $product->variant_id ? 'selected' : '' !!}>
                                {!! 'ID ' . $variant->id !!}{!! ': ' . $variant->variants !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Categorías</label>
                    <div id="categories">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="row justify-content-between"
                                id={!!"category_id_" . $i!!}
                                style="{!!$i < $product->categories()->count() ? 'display: block':'display:none'!!}">
                                <select name={!!"category_id_" . $i!!}>
                                    @foreach ($categories as $key => $category)
                                        <option value="{!! $category['id'] !!}"
                                            {!! $product->hasCategory($i, $category['id']) ? 'selected' : '' !!}
                                            {!! $category['disabled'] === true ? 'disabled' : '' !!}>{!! $category['name'] !!}
                                        </option>
                                    @endforeach
                                </select>
                                <a class="btn btn-danger ml-3" onclick="deleteCategory({!!'category_id_' . $i!!})">
                                    <span style="color: white">
                                        - Borrar
                                    </span>
                                </a>
                            </div>
                        @endfor
                    </div>
                    <a class="btn btn-primary mt-3" onclick="addCategory()">
                        <span style="color: white">
                            + Categoria
                        </span>
                    </a>
                </div>
            </div>
            <div class="row mt-5 justify-content-end">
                <button class="btn btn-success" type="submit">
                    <span style="color: white">
                        GUARDAR
                    </span>
                </button>
            </div>
        </div>

    </form>

@endsection

@section('script')
    <script>
        var count = 0;
        function addCategory() {
            count++;
            if(count > 4) count = 4;
            document.getElementById('category_id_' + count).style.display = "block";
        }
        function deleteCategory(element){
            count--;
            if(count < -1) count = -1;
            id = element.id;
            document.getElementById(id).style.display = "none";
            element.firstElementChild.selectedIndex = 0;
        }
    </script>
@endsection
