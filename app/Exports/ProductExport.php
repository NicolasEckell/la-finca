<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $csv_header = ["Identificador de URL","Nombre", "Categorías","Nombre de propiedad 1", "Valor de propiedad 1","Nombre de propiedad 2","Valor de propiedad 2","Nombre de propiedad 3","Valor de propiedad 3","Precio","Precio promocional","Peso","Stock","SKU","Código de barras","Mostrar en tienda","Envío sin cargo","Descripción","Tags","Título para SEO","Descripción para SEO","Marca"];

    public function array(): array
    {
        return app()->make('App\Http\Controllers\ExportController')->exportProducts();
    }

    public function headings(): array
    {
        return $this->csv_header;
    }
}
