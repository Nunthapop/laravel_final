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
    function showUpdateForm(string $productCode): View
    {
        $product = $this->find($productCode);

        return view('products.update-form', [
            'title' => "{$this->title} : Update",
            'product' => $product,
        ]);
    }
    function update(ServerRequestInterface $request, string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save();
        return redirect()->route('products.view', ['product' => $product->code]);
    }
    function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();
        return redirect()->route('products.list');
    }
    //price_filter
    function prepareSearch(array $search): array
    {
        $search = parent::prepareSearch($search);
        $search = \array_merge([
            'minPrice' => null,
            'maxPrice' => null,
        ], $search);
        return $search;
    }
    function filterByPrice(
        Builder $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }
    function filter(Builder $query, array $search): Builder
    {
        $query = parent::filter($query, $search);
        $query = $this->filterByPrice(
            $query,
            ($search['minPrice'] === null) ? null : (float) $search['minPrice'],
            ($search['maxPrice'] === null) ? null : (float) $search['maxPrice'],
        );

        return $query;
    }
}
