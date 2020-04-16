<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductStockImport implements ToCollection, WithStartRow {

    public function collection(Collection $rows){
        $data = $_SESSION['data'];
        
        foreach ($rows as $row){
            $product = new Product([
                'code'          => $row[0],
                'name'          => $row[1], 
                'categories'    => $row[2],
                'stock'         => $row[5],
            ]);
            array_push($data,$product);
        }

        $_SESSION['data'] = $data;
    }

    public function startRow(): int{
        return 2;
    }
}