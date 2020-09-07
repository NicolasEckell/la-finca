<div class="d-flex align-items-center mt-3 flex-column">
    <div class="col-sm-8 badge badge-outline-success badge-button">
        <h4 style="color:black">Cargar archivos de productos</h4>
        <strong style="color:black" class="mt-5">
            Para actualizar productos previamente cargados, utilizar esta carga
        </strong>
        {!!Form::open(['url'=>'importar', 'method'=>'POST','files'=>true])!!}
        <div class="d-flex flex-row justify-content-center mt-5">
            <div class="d-flex flex-column align-items-start mr-5">
                <span style="color:black" class="mb-2">
                    Cargar archivo de STOCK 'Productos stock generalizado'
                </span>
                {!!Form::file('stock')!!}
                <span style="color:orange;">
                    Este <strong>ARCHIVO</strong> actualiza: "nombre" y "stock"
                </span>
            </div>
            <div class="d-flex flex-column align-items-start">
                <span style="color:black" class="mb-2">
                    Cargar archivo de LISTADO 'Blanco productos'
                </span>
                {!!Form::file('listado')!!}
                <span style="color:orange;">
                    Este <strong>ARCHIVO</strong> actualiza: "precio", "detalle", "proveedor" y "codigo de barras"
                </span>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {!!Form::submit('Siguiente',['class'=>'btn btn-success ml-3','id'=>'submit'])!!}
        </div>
        {!!Form::close()!!}
    </div>
    <div class="badge badge-outline-danger badge-button mt-3">
        <h4 style="color:black">Cargar archivos de categorías</h4>
        <strong style="color:black">
            Para la carga de productos nuevos, utilice este carga para configurar la categoría
        </strong>
        {!!Form::open(['url'=>'importarCategorias', 'method'=>'POST','files'=>true])!!}
        <div class="d-flex mt-5">
            <div class="d-flex flex-column align-items-center">
                <span style="color:black" class="mb-2">
                    Cargar archivo de 'Categorías'
                </span>
                {!!Form::file('categorias')!!}
                <span style="color:orange;">
                    Este <strong>ARCHIVO</strong> Crea nuevas categorías del sistema (interno). Crea nuevos productos (utiliza "código" y "nombre").
                </span>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {!!Form::submit('Siguiente',['class'=>'btn btn-success ml-3','id'=>'submit'])!!}
        </div>
        {!!Form::close()!!}
    </div>
</div>


