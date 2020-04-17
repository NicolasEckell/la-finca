<div class="d-flex justify-content-start mt-3">
    <div class="badge badge-outline-success badge-button mr-5">
        <h6 style="color:black">Cargar archivos de productos</h6>
        
        {!!Form::open(['url'=>'importar', 'method'=>'POST','files'=>true])!!}
        <div class="d-flex mt-5">
            <div class="d-flex flex-column align-items-start mr-5">
                <span style="color:black" class="mb-2">
                    Cargar archivo de STOCK 'Productos stock generalizado'
                </span>
                {!!Form::file('stock')!!}
            </div>
            <div class="d-flex flex-column align-items-start">
                <span style="color:black" class="mb-2">
                    Cargar archivo de LISTADO 'Blanco productos'
                </span>
                {!!Form::file('listado')!!}
            </div>
        </div>
        <br><br>
        <strong style="color:black">
            Para actualizar productos previamente cargados, utilizar esta carga
        </strong>
        <div class="d-flex justify-content-center mt-3">
            {!!Form::submit('Siguiente',['class'=>'btn btn-success ml-3','id'=>'submit'])!!}
        </div>
        {!!Form::close()!!}
    </div>
    <div class="badge badge-outline-warning badge-button">
        <h6 style="color:black">Cargar archivos de categorías</h6>

        {!!Form::open(['url'=>'importarCategorias', 'method'=>'POST','files'=>true])!!}
        <div class="d-flex mt-5">
            <div class="d-flex flex-column align-items-center">
                <span style="color:black" class="mb-2">
                    Cargar archivo de 'Categorías'
                </span>
                {!!Form::file('categorias')!!}
            </div>
        </div>
        <br><br>
        <strong style="color:black">
            Para la carga de productos nuevos, utilice este carga para configurar la categoría
        </strong>
        <div class="d-flex justify-content-center mt-3">
            {!!Form::submit('Siguiente',['class'=>'btn btn-success ml-3','id'=>'submit'])!!}
        </div>
        {!!Form::close()!!}
    </div>
</div>


