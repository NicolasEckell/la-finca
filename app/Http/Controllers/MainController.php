<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Imports\ProductListadoImport;
use App\Imports\ProductStockImport;
use App\Imports\ProductCategoriasImport;

use Excel;
use Input;
use App;

use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\CharsetConverter;
use SplTempFileObject;

class MainController extends Controller {

	private $filename_stock_generalizado = "Productos stock generalizado.xlsx";
	private $filename_listado = "Blanco productos.xlsx";
	private $filename_categorias = "Categorias.xlsx";
	private $csv_header = ["Identificador de URL","Nombre", "Categorías","Nombre de propiedad 1", "Valor de propiedad 1","Nombre de propiedad 2","Valor de propiedad 2","Nombre de propiedad 3","Valor de propiedad 3","Precio","Precio promocional","Peso","Stock","SKU","Código de barras","Mostrar en tienda","Envío sin cargo","Descripción","Tags","Título para SEO","Descripción para SEO","Marca"];
	private $csvname = "productos.csv";


	public function importar(Request $request){

		$file_input = request()->file('stock');

		if($file_input && strcmp($file_input->getClientOriginalName(), $this->filename_stock_generalizado) == 0){
			$_SESSION['data'] = [];
			Excel::import(new ProductStockImport, $file_input);
			$N = $this->processStock($_SESSION['data']);
			if($N > 0)
				abort(500,"Has ingresado un producto nuevo. Debes cargarlo primero la por Categorías, luego carga normal'");
		}
		else{
			abort(500,"Falta ingresar el archivo ".$this->filename_stock_generalizado);
		}

		$file_input = request()->file('listado');

		if($file_input && strcmp($file_input->getClientOriginalName(), $this->filename_listado) == 0){
			$_SESSION['data'] = [];
			Excel::import(new ProductListadoImport, $file_input);
			$this->processListado($_SESSION['data']);
			if($N > 0)
				abort(500,"Has ingresado un producto nuevo. Debes hacer la carga primero por Categorías, luego esta carga normal'");
		}
		else{
			abort(500,"Falta ingresar el archivo ".$this->filename_listado);
		}
		$this->generateCsv();
	}

	public function importarCategorias(request $request){
		$file_input = request()->file('categorias');

		if($file_input && strcmp($file_input->getClientOriginalName(), $this->filename_categorias) == 0){
			$_SESSION['data'] = [];
			Excel::import(new ProductCategoriasImport,$file_input);
			[$N_old,$N_new] = $this->processCategories($_SESSION['data']);
			abort(200,$N_new." Productos Nuevos. ".$N_old." Productos Actualizados");
		}
		else{
			abort(200,"Falta ingresar el archivo ".$this->filename_categorias);
		}
	}

	private function processStock($array){
		$N = 0;
		for ($i=0; $i < count($array) ; $i++) {
			$product = $array[$i];
			$exist = App::make('App\Http\Controllers\ProductController')->findProductByCode($product->code);
			if($exist){
				$exist->name = $product->name;
				$exist->stock = $product->stock;
				$exist->save();
			}
			else{
				$N++;
			}
		}
		return $N;
	}

	private function processListado($array){
		$N = 0;
		for ($i=0; $i < count($array) ; $i++) {
			$product = $array[$i];
			$exist = App::make('App\Http\Controllers\ProductController')->findProductByCode($product->code);
			if($exist){
				$exist->price = $product->price;
				$exist->details = $product->details;
				$exist->vendor = $product->vendor;
				$exist->save();
			}
			else{
				$N++;
			}
		}
		return $N;
	}

	private function processCategories($array){
		$N_new = 0;
		$N_old = 0;
		for ($i=0; $i < count($array) ; $i++) {
			$new = $array[$i];
			$old = App::make('App\Http\Controllers\ProductController')->findProductByCode($new->code);
			if(!$old){
				$new->save();
				$N_new++;
			}
			else{
				$old->categories = $new->categories;
				$old->save();
				$N_old++;
			}
		}
		return [$N_old,$N_new];
	}

	private function generateCsv(){
		$encoder = (new CharsetConverter())->inputEncoding('utf-8')->outputEncoding('iso-8859-3');
		$data = App::make('App\Http\Controllers\ProductController')->getAllReady2Export();
		$csv = Writer::createFromFileObject(new SplTempFileObject());
		$csv->addFormatter($encoder);
		$csv->insertOne($this->csv_header);
		foreach ($data as $key => $item) {
			$csv->insertOne($item);
		}
		$csv->output($this->csvname);
	}


}