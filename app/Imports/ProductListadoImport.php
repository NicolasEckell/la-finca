<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductListadoImport implements ToCollection, WithStartRow {

    public function collection(Collection $rows){
        $data = $_SESSION['data'];
        
        foreach ($rows as $row){
            $product = new Product([
                'code'          => $row[0],
                'name'          => $row[1],
                'price'         => $row[4],
                'details'       => $row[9],
                'vendor'        => $row[19],
            ]);
            array_push($data,$product);
        }

        $_SESSION['data'] = $data;
    }

    public function startRow(): int{
        return 2;
    }
}