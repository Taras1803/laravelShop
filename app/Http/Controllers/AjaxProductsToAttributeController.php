<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\ProductsToAttributes;
use Illuminate\Http\Request;


class AjaxProductsToAttributeController extends Controller
{
    public function store(Request $request)
    {

        if($request->id == 0)
            $value = new ProductsToAttributes();
        else
            $value = ProductsToAttributes::find($request->id);

        $value->product_id = (int)$request->product_id;
        $value->attribute_id = (int)$request->item['attribute_id'];
        $value->attribute_value_id = (int)$request->item['attribute_value_id'];
        $value->save();
    }

    public function destroy($id)
    {
        header('Content-Type: text/html; charset=utf-8');
        ob_start();
        if(ProductsToAttributes::find($id)->delete())
            echo 'done';
        ob_end_flush();
        die;
    }
}