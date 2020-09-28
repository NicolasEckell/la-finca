<div class="d-flex align-items-start mt-3 flex-row">
    <div class="mt-3 col-sm-6">
        <div class="card">
            <div class="card-header">Paso 1: Carga del archivo "Productos Stock"</div>
            <div class="card-body">
                {!!Form::open(['url'=>'importStock', 'method'=>'POST','files'=>true])!!}
                {!!Form::file('stock',['class' => 'mt-3'])!!}
                <p class="card-text mt-3" style="color:orange;">
                    Este <strong>ARCHIVO</strong><br>
                    1) ACTUALIZA el nombre y el stock de los productos existentes, no actualiza la categoría ingresada.<br>
                    2) CREA nuevos productos, IGNORA la categoría ingresada.<br>
                    3) DESACTIVA PRODUCTOS. Si existía algún producto, pero no se ingresó en este archivo, se lo deja como NO MOSTRAR EN TIENDA, de lo contrario si está aquí se mostrará en tienda.
                </p>
                <div class="d-flex justify-content-center mt-3">
                    {!!Form::submit('Siguiente',['class'=>'btn btn-success ml-3','id'=>'submit'])!!}
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    <div class="mt-3 col-sm-6">
        <div class="card">
            <div class="card-header">Paso 2: Carga del archivo "Productos Listado"</div>
            <div class="card-body">
                {!!Form::open(['url'=>'importListado', 'method'=>'POST','files'=>true])!!}
                {!!Form::file('listado',['class' => 'mt-3'])!!}
                <p class="card-text mt-3" style="color:orange;">
                    Este <strong>ARCHIVO</strong><br>
                    1) ACTUALIZA: precio, detalle, proveedor y codigo de barras.<br>
                    2) NO CREA nuevos productos. Si se han ingresado nuevos productos, se notificará al final del proceso.<br>
                    3) DESACTIVA PRODUCTOS. Si existía algún producto, pero no se ingresó en este archivo, se lo deja como NO MOSTRAR EN TIENDA, de lo contrario si está aquí se mostrará en tienda.
                </p>
                <div class="d-flex justify-content-center mt-3">
                    {!!Form::submit('Siguiente',['class'=>'btn btn-success ml-3','id'=>'submit'])!!}
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>