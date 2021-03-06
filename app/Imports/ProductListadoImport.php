<?php

namespace App\Imports;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductListadoImport implements ToCollection, WithStartRow {

    public function collection(Collection $collection){
        $productService = new ProductService;

        $productService->turnOffAll();

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
            $exist = $productService->findProductByCode($product->code);
            if($exist){
                //Producto existente, actualizar precio, detalles, proveedor y codigo de barras
                $exist->price = $this->formatPrice($product->price);
                $exist->details = $product->details;
                $exist->vendor = $product->vendor;
                $exist->barcode = $product->barcode;
                $exist->showOnStore = $productService->isValidProduct($exist);
                $exist->save();
                $N['update']++;
            }
            else{
                $N['new']++;
            }
        }

        $N['delete'] = $productService->getTurnedOff();
        $_SESSION['N'] = $N;
    }

    public function formatPrice($price){
        $pos = strpos($price, '$');
        if (!$pos) return $price;
        $price = substr($price, $pos + 1);

        $pos = strpos($price, ',');
        if (!$pos) return $price;
        $price = substr($price, 0, $pos). "." . substr($price, $pos + 1);

        return (float) $price;
    }

    public function startRow(): int{
        return 2;
    }
}
