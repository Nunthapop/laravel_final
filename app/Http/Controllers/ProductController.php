<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;


  class ProductController extends SearchableController
{
    // At the top of file
    // We alias ServerRequestInterface to Request for short
    // Add the following property and methods in class body
    private string $title = 'Product';
    public function getQuery(): Builder
    {
        //return ข้อมูลจาก database เรียงตาม code
        // Return the query builder for the Product model
        return Product::orderby('code');
    }

    function list(ServerRequestInterface $request): View
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        return view('products.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'products' => $query->paginate(5),
        ]);
    }

    function show(string $productCode): View
    {
        $product = $this->find($productCode);
        return view('products.view', [
            'title' => "{$this->title} : View",
            'product' => $product,
        ]);
    }
    //create part
    function showCreateForm(): View
    {
        return view('products.create-form', [
            'title' => "{$this->title} : Create ",
        ]);
    }
    function create(ServerRequestInterface $request): RedirectResponse
    {
        $product = Product::create($request->getParsedBody());
        return redirect()->route('products.list');
    }
    //update part
    
}
