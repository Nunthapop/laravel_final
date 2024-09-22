<?php

namespace App\Http\Controllers;


use App\Models\Shop;
use Illuminate\View\View;
use App\Models\shops;
use App\Models\Product;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ShopController extends SearchableController
{
    private string $title = 'Shop';
    public function getQuery(): Builder
    {
        //return ข้อมูลจาก database เรียงตาม code
        // Return the query builder for the shop model
        return shop::orderby('code');
    }


    //list
    function list(ServerRequestInterface $request): View
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search)->withCount('products'); //products from method in shop model
        //Shop Models
        return view('shops.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'shop' => $query->paginate(5),

        ]);
    }
    //view
    function show(string $ShopName): View
    {
        //where follow by shopName
        $name = Shop::where('code', $ShopName)->firstOrFail();
        return view('shops.view', [
            'title' => "{$this->title} : list",
            'shop' => $name,
        ]);
    }
    //create
    function showCreateForm(): View
    {
        return view('shops.create-form', [
            'title' => "{$this->title} : Create ",
        ]);
    }
    function create(ServerRequestInterface $request): RedirectResponse
    {
        $shops = Shop::create($request->getParsedBody());
        return redirect()->route('shops.list');
    }

    //update
    function showUpdateForm(string $shopsCode): View
    {
        $shop = $this->find($shopsCode);

        return view('shops.update-form', [
            'title' => "{$this->title} : Update",
            'shop' => $shop,
        ]);
    }

    function update(ServerRequestInterface $request, string $shopCode): RedirectResponse
    {

        $shop = $this->find($shopCode);
        $shop->fill($request->getParsedBody());
        $shop->save();
        return redirect()->route('shops.view', ['shop' => $shop->code]);
    }
    //delete
    function delete(string $shopCode): RedirectResponse
    {
        $shop = $this->find($shopCode);
        $shop->delete();
        return redirect()->route('shops.list');
    }
    //search part
    function filterByTerm(Builder|Relation $query, ?string $term): Builder|Relation
    {


        if (!empty($term)) {
            foreach (\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word) {
                    $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', function (Builder $query) use ($word) {
                            $query->where('name', 'LIKE', "%{$word}%");
                        });
                });
            }
        }

        return $query;
    }
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
    //show product
    function showProducts(
        ServerRequestInterface $request,
        ProductController $ProductController,
        string $shopCode
    ): View {
        $shops = $this->find($shopCode);
        $search = $ProductController->prepareSearch($request->getQueryParams());
        $query = $ProductController->filter($shops->products(), $search);

        return view('shops.view-products', [
            'title' => "{$this->title} {$shops->code} : Products",

            'shops' => $shops,
            'search' => $search,
            'products' => $query->paginate(5),
        ]);
    }
    //shops.add-products-form
    function showAddProductsForm(
        string $shopCode,
        ProductController $productController,
        ServerRequestInterface $request
    ): View {
        $shop = $this->find($shopCode);
        $search = $productController->prepareSearch($request->getQueryParams());
        $query = Product::orderBy('code')
            ->whereDoesntHave('shops', function (Builder $innerQuery) use ($shop) {
                return $innerQuery->where('code', $shop->code);
            });
        $query = $productController->filter($query, $search);
        // Filter out shops that already have the product
        return view('shops.add-products-form', [
            'title' => "{$this->title} {$shop->code} : Add Products",
            'search' => $search,
            'shops' => $shop,
            'products' => $query->paginate(5),
        ]);
    }
   //Redirect to shops.add-products-form
    function addProduct(ServerRequestInterface $request, string $shopCode): RedirectResponse
    {
        $shop = $this->find($shopCode);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $product = Product::whereDoesntHave('shops', function (Builder $innerQuery) 
        use ($shop) {
            return $innerQuery->where('code', $shop->code);
        })->where('code', $data['shop'])->firstOrFail();
        $shop->products()->attach($product);
        return redirect()->back();
    }
    //remove Redirect to shops.add-products-form
    function removeProduct(
        string $shopCode,
        string $productCode // เรียง parameter ตาม route = {shop} / {product}
    ): RedirectResponse {
        $shop = $this->find($shopCode);
        //find in product table where code = $productCode
        $product = $shop->products()->where('code', $productCode)->firstOrFail();
        $shop->products()->detach($product);
        return redirect()->back();
    }
}
