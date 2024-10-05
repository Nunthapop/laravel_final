<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;



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

    function list(ServerRequestInterface $request, CateController $categoryController): View
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search)->withCount('shops');
        $categories = Category::all();

        return view('products.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'products' => $query->paginate(5),
            'category' => $categories,
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
        Gate::authorize('create', Product::class);
        $categories = Category::all();
        return view('products.create-form', [
            'title' => "{$this->title} : Create ",
            'categories' => $categories
        ]);
    }
    function create(ServerRequestInterface $request): RedirectResponse
    {
        Gate::authorize('create', Product::class);
        $data = $request->getParsedBody();
        dd($data);
    // Ensure the 'category_id' field is included in the parsed body
        $product = Product::create([
        'code' => $data['code'],
        'name' => $data['name'],
        'price' => $data['price'],
        'description' => $data['description'],
        'category_id' => $data['category_id'],  // Make sure this is passed
    ]);
        return redirect()->route('products.list');
    }
    //update part
    function showUpdateForm(string $productCode): View
    {
        Gate::authorize('update', Product::class);
        $product = $this->find($productCode);
        $categories = Category::all();
        // $categories = 
        return view('products.update-form', [
            'title' => "{$this->title} : Update",
            'product' => $product,
            'categories' => $categories
        ]);
    }
    function update(ServerRequestInterface $request, string $productCode): RedirectResponse
    {
        Gate::authorize('update', Product::class);
        $product = $this->find($productCode);
        $product->fill($request->getParsedBody());
        $product->save();
        return redirect()->route('products.view', ['product' => $product->code])->with('message', 'Product has been updated');
    }
    function delete(string $productCode): RedirectResponse
    {
        Gate::authorize('delete', Product::class);
        $product = $this->find($productCode);
        $product->delete();
        return redirect()->route('products.list');
    }
    //search part
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
    function filterByTerm(Builder|Relation $query, ?string $term): Builder|Relation
    {


        if (!empty($term)) {
            foreach (\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word) {
                    $innerQuery
                        ->where('code', 'LIKE', "%{$word}%")
                        ->orWhere('name', 'LIKE', "%{$word}%")
                        // Join with categories table to search by category name
                        ->orWhereHas('category', function (Builder $query) use ($word) {
                            $query->where('name', 'LIKE', "%{$word}%");
                        });
                });
            }
        }
        
        return $query;
        
    }
    //products.view-shops
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
            'products' => $product,
            'search' => $search,
            'shops' => $query->paginate(5),
        ]);
    }
    //products.add-shops-form
    function showAddShopsForm(
        string $productCode,
        ShopController $shopController,
        ServerRequestInterface $request
    ): View {
        Gate::authorize('update', Product::class);
        $product = $this->find($productCode);
        $search = $shopController->prepareSearch($request->getQueryParams());
        $query = Shop::orderBy('code')
            ->whereDoesntHave('products', function (Builder $innerQuery) use ($product) {
                return $innerQuery->where('code', $product->code);
            });
        $query = $shopController->filter($query, $search);
        // Filter out shops that already have the product
        return view('products.add-shops-form', [
            'title' => "{$this->title} {$product->code} : Add Shops",
            'search' => $search,
            'products' => $product,
            'shops' => $query->paginate(5),
        ]);
    }
    //Redirect to products.add-shops-form
    function addShop(ServerRequestInterface $request, string $productCode): RedirectResponse
    {
        Gate::authorize('update', Product::class);
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $shop = Shop::whereDoesntHave('products', function (Builder $innerQuery) use ($product) {
            return $innerQuery->where('code', $product->code);
        })->where('code', $data['shop'])->firstOrFail();
        
        $product->shops()->attach($shop);
        return redirect()->back()->with('message', "{$shop->code} has been added to {$product->code}");
    }
    ///Redirect to products.add-shops-form
    function removeShop(
        string $productCode,
        string $shopCode
    ): RedirectResponse {
        Gate::authorize('update', Product::class);
        $product = $this->find($productCode);
        $shop = $product->shops()->where('code', $shopCode)->firstOrFail();
        $product->shops()->detach($shop);
        return redirect()->back()->with('message', "{$shop->code} has been removed from {$product->code}");
    }
}
