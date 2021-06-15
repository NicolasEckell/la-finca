<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\VariantService;

class ProductController extends Controller
{

    public function index()
    {
        $products = (new ProductService)->getAll();
        $variants = (new VariantService)->getAll();
        return view('products.index')->with('products', $products)->with('variants', $variants);
    }

    public function edit($id)
    {
        $product = (new ProductService)->findProductById($id);
        if (!$product) return -1;

        $variants = (new VariantService)->getAll();
        $categories = (new CategoryService)->getListed();
        return view('products.edit')->with('product', $product)->with('variants', $variants)->with('categories', $categories);
    }

    public function update(Request $request)
    {
        if (!isset($request['id'])) return -1;
        $product = (new ProductService)->findProductById($request['id']);
        if (!$product) return -1;

        if (!isset($request['variant_id']) || !isset($request['category_id_0']))
            return -1;

        $product->categories()->detach();
        for ($i = 0; $i < 5; $i++) {
            if (isset($request['category_id_' . $i]) && $request['category_id_' . $i] != null) {
                $cat = (new CategoryService)->getById($request['category_id_' . $i]);
                if (!($cat instanceof Category)) return -1;
                $product->addCategory($cat);
            }
        }

        if ($request['variant_id'] != 0) {
            $variant = (new VariantService)->getById($request['variant_id']);
            if (!$variant)
                return -1;
            else {
                $product->type = "Peso";
                $product->variant_id = $request['variant_id'];
            }
        } else {
            $product->type = "Unidad";
            $product->variant_id = null;
        }

        if (isset($request['showOnStore'])) {
            $product->showOnStore = true;
        } else {
            $product->showOnStore = false;
        }

        $product->save();

        return redirect()->route('products');
    }
}
