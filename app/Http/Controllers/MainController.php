<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Imports\ProductListadoImport;
use App\Imports\ProductStockImport;

use Excel;
use Input;
use App;

use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\CharsetConverter;
use SplTempFileObject;

class MainController extends Controller {

	private $csv_header = ["Identificador de URL","Nombre", "Categorías","Nombre de propiedad 1", "Valor de propiedad 1","Nombre de propiedad 2","Valor de propiedad 2","Nombre de propiedad 3","Valor de propiedad 3","Precio","Precio promocional","Peso","Stock","SKU","Código de barras","Mostrar en tienda","Envío sin cargo","Descripción","Tags","Título para SEO","Descripción para SEO","Marca"];
	private $csvname = "productos.csv";

	public function importListado(Request $request){
		$file_input = request()->file('listado');

		if($file_input){
			$_SESSION['data'] = [];
			Excel::import(new ProductListadoImport, $file_input);
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
	
	public function corrector(){
		App::make('App\Http\Controllers\ExportController')->corrector();
		abort(200,"Todo OK!");
	}

	public function exportar(){
		return $this->generateCsv();
	}

	private function generateCsv(){
		$encoder = (new CharsetConverter())->inputEncoding('utf-8')->outputEncoding('iso-8859-3');
		$data = App::make('App\Http\Controllers\ExportController')->exportProducts();
		$csv = Writer::createFromFileObject(new SplTempFileObject());
		$csv->addFormatter($encoder);
		$csv->setDelimiter(';');
		$csv->insertOne($this->csv_header);
		foreach ($data as $key => $item) {
			$csv->insertOne($item);
		}
		$csv->output($this->csvname);
	}


}