<?php


namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\ProductsAttributesValue;


class SiteController extends Controller
{
    public function index()
    {

        $data = Categorie::getCatalogData();
        return view('site/catalog', compact('data'));
    }

}