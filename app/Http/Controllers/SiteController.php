<?php


namespace App\Http\Controllers;

use App\Models\Categorie;


class SiteController extends Controller
{
    public function index()
    {
        $data = Categorie::getCatalogData();
        return view('site/catalog', compact('data'));
    }

}