<?php

namespace App\Imports;

use App\Product;
use App\Services\ProductService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductStockImport implements ToCollection, WithStartRow {

    public function collection(Collection $collection){
        // $data = $_SESSION['data'];
        $productService = new ProductService;

        $productService->turnOffAll();

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
            $exist = $productService->findProductByCode($code);
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
                $exist->showOnStore = $productService->isValidProduct($exist);
                $exist->save();
                $N['update']++;
            }
        }
        $N['delete'] = $productService->getTurnedOff();
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

    public function startRow(): int{
        return 2;
    }
}
