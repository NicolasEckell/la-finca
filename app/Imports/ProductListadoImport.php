<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App;

class ProductListadoImport implements ToCollection, WithStartRow {

    public function collection(Collection $collection){
        $productController = App::make('App\Http\Controllers\ProductController');

        $productController->turnOffAll();

        $N = [
            'new' => 0,
            'update' => 0,
            'delete' => 0,
        ];

        foreach ($collection as $row){
            $product = new Product([
                'code'          => $row[0],
                'name'          => $row[1],
                'price'         => $row[4],
                'details'       => $row[9],
                'vendor'        => $row[19],
                'barcode'       => $row[21]
            ]);
            $exist = $productController->findProductByCode($product->code);
            if($exist){
                //Producto existente, actualizar precio, detalles, proveedor y codigo de barras
                $exist->price = $product->price;
                $exist->details = $product->details;
                $exist->vendor = $product->vendor;
                $exist->barcode = $product->barcode;
                $exist->showOnStore = true;
                $exist->save();
                $N['update']++;
            }
            else{
                $N['new']++;
            }
        }

        $N['delete'] = $productController->getTurnedOff();
        $_SESSION['N'] = $N;
    }

    public function startRow(): int{
        return 2;
    }
}