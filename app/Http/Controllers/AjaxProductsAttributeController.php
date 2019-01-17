<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\ProductsAttributesValue;
use Illuminate\Http\Request;


class AjaxProductsAttributeController extends Controller
{
    public function store(Request $request)
    {
     if($request->id == 0)
         $value = new ProductsAttributesValue;
     else
         $value = ProductsAttributesValue::find($request->id);

      $value->product_attributes_id = (int)$request->attributes_id;
      $value->value = $request->item['value'];
      $value->save();
    }

    public function destroy($id)
    {
        if(ProductsAttributesValue::find($id)->delete())
            echo 'done';
    }
}