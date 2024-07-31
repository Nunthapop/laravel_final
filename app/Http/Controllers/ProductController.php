<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    // At the top of file
    // We alias ServerRequestInterface to Request for short
    // Add the following property and methods in class body
    private string $title = 'Product';

    function list(): View
    {
       
      $products = Product::orderby('code')->get();
        return view('products.list', [
            'title' => "{$this->title} : List",
            'products' => Product::orderBy('code')->get(),
        ]);
    }
    function show(string $productCode): View
    {
        $product = Product::where('code',$productCode)->firstOrFail();
        return view('products.view', [
            'title' => "{$this->title} : list",
            'product' => $product,
        ]);
    }
}
