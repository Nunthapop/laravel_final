<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;


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
        $query = $this->search($search)->withCount('shops');
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
        Builder|Relation $query,
        ?float $minPrice,
        ?float $maxPrice
    ): Builder|Relation {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }
    function filter(Builder|Relation $query, array $search): Builder|Relation
    {
        $query = parent::filter($query, $search);
        $query = $this->filterByPrice(
            $query,
            ($search['minPrice'] === null) ? null : (float) $search['minPrice'],
            ($search['maxPrice'] === null) ? null : (float) $search['maxPrice'],
        );
        return $query;
    }
    function filterByTerm(Builder|Relation $query, ?string $term): Builder|Relation
    {


        if (!empty($term)) {
            foreach (\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word) {
                    $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%");
                });
            }
        }

        return $query;
    }
    function showShops(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        $product = $this->find($productCode);
        $search = $shopController->prepareSearch($request->getQueryParams());
        $query = $shopController->filter($product->shops(), $search);

        return view('products.view-shops', [
            'title' => "{$this->title} {$product->code} : Shop",

            'product' => $product,
            'search' => $search,
            'shops' => $query->paginate(5),
        ]);
    }
}
