<?php


namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;

class CatalogController extends Controller
{
    public function category($slug)
    {
        $data = Categorie::getCategoryData($slug);
        return view('site/category', compact('data'));
    }

    public function product($slug)
    {
        $data = Product::getProductData($slug);
        return view('site/product', compact('data'));
    }
}