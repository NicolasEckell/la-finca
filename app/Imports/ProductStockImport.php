<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App;

class ProductStockImport implements ToCollection, WithStartRow {

    public function collection(Collection $collection){
        // $data = $_SESSION['data'];
        $productController = App::make('App\Http\Controllers\ProductController');
        $categoryController = App::make('App\Http\Controllers\CategoryController');
        
        $productController->turnOffAll();

        $N = [
            'new' => 0,
            'update' => 0,
            'delete' => 0,
        ];

        foreach ($collection as $row){
            $newProduct = new Product([
                'code'          => $row[0],
                'name'          => $row[1],
                'categories'    => $row[2],
                'stock'         => $row[5],
                'showOnStore'   => false,
            ]);
            $code = $row[0];
            $exist = $productController->findProductByCode($code);
            if(!$exist){
                //Nuevo producto, agregar categoria
                // $cat = $categoryController->createFromString($newProduct->categories);
                $newProduct->save();
                // $newProduct->addCategory($cat);
                $N['new']++;
            }
            else{
                //Producto existente, ignorar la categoria, actualizar stock y nombre
                $exist->name = $newProduct->name;
                $exist->stock = $this->parseStock($newProduct);
                $exist->showOnStore = $this->isValidProduct($exist);
                $exist->save();
                $N['update']++;
            }
        }

        $N['delete'] = $productController->getTurnedOff();
        $_SESSION['N'] = $N;
    }

    public function parseStock(Product $product){
        $stock = (int) $product->stock;
        if($stock <= 0){
            return 0;
        }
        else{
            return $stock;
        }
    }

    public function isValidProduct(Product $product){
        $cat = $product->categories()->first();
        if((int) $product->price <= 0){
            return false;
        }
        if($cat){
            if($cat->isRoot()){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return false;
        }
    }

    public function startRow(): int{
        return 2;
    }
}