<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Excel;
use App\Imports\ProductListadoImport;
use App\Imports\ProductStockImport;
use App\Exports\ProductExport;

class MainController extends Controller {

	private $csvname = "productos.csv";

	public function importListado(Request $request){
		$file_input = request()->file('listado');

		if($file_input){
			$_SESSION['data'] = [];
			Excel::toArray(new ProductListadoImport, $file_input);
			$N = $_SESSION['N'];
			abort(200,$N['new']." Productos Nuevos (pero no fueron creados, deben ser ingresados primero desde el archivo de Stock). ".$N['update']." Productos Actualizados. ".$N['delete']." Productos detectados Fuera de la Tienda");
		}
		else{
			abort(200,"Error!");
		}
	}

	public function importStock(request $request){
		$file_input = request()->file('stock');

		if($file_input){
			$_SESSION['N'] = [];
			Excel::import(new ProductStockImport,$file_input);
			$N = $_SESSION['N'];
			abort(200,$N['new']." Productos Nuevos. ".$N['update']." Productos Actualizados. ".$N['delete']." Productos Fuera de la Tienda");
		}
		else{
			abort(200,"Error!");
		}
	}

    public function exportar(){
        return (new ProductExport())->download($this->csvname, \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

	public function corrector(){
		app()->make('App\Http\Controllers\CorrectorController')->corrector();
		abort(200,"Todo OK!");
	}

}
