<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class CateController extends SearchableController
{
    private string $title = 'Category';
    public function getQuery(): Builder
    {
        //return ข้อมูลจาก database เรียงตาม code
        // Return the query builder for the Product model
        return Category::orderby('code');
    }
    
    //list
    function list(ServerRequestInterface $request): View
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        //category Models
        return view('category.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'category' => $query->paginate(5),

        ]);
    }
    //view
    function show(string $cateCode): View
    {
        $Cates = $this->find($cateCode);
        return view('category.view', [
            'title' => "{$this->title} : View",
            'Cates' => $Cates,
        ]);
    }
    //create 
    function showCreateForm(): View
    {
        return view('category.create-form', [
            'title' => "{$this->title} :Create"
        ]);
    }
    function create(ServerRequestInterface $request): RedirectResponse
    {
        $category = Category::create($request->getParsedBody());
        return redirect()->route('category.list')->with('message', "Category {$category->name} created successfully");
    }
    //update
    function showUpdateForm(string $cateCode): View
    {
        $category = $this->find($cateCode);

        return view('category.update-form', [
            'title' => "{$this->title} : Update",
            'categoryN' => $category,
        ]);
    }
    function update(ServerRequestInterface $request, string $cateCode): RedirectResponse
    {

        $category = $this->find($cateCode);
        $category->fill($request->getParsedBody());
        $category->save();
        return redirect()->route('category.view', ['cateCode' => $category->code])->with('message', "Category {$category->name} updated successfully");
    }
    //delete
    function delete(string $cateCode): RedirectResponse
    {
        $category = $this->find($cateCode);
        $category->delete();
        return redirect()->route('category.list')->with('message', "Category {$category->name} deleted successfully");
    }
    //show
    function showProducts(
        ServerRequestInterface $request,
        ProductController $productController,
        string $cateCode
    ): View {
        $category = $this->find($cateCode);
        $search = $productController->prepareSearch($request->getQueryParams());
        $query = $productController->filter($category->products(), $search);
        return view("Category.view-products", [
            'title' => "{$this->title} {$category->code} : Products",

            'category' => $category,
            'search' => $search,
            'products' => $query->paginate(5),
        ]);
    }
    //shops.add-products-form
    function showAddProductsForm(
        string $cateCode,
        ProductController $productController,
        ServerRequestInterface $request
    ): View {
        $category = $this->find($cateCode);
        $search = $productController->prepareSearch($request->getQueryParams());
        $query = Product::orderBy('code')
            //'category': This is the name of the relationship method in the Product model. Eloquent uses this to find the corresponding Category model for filtering.
            ->whereDoesntHave('category', function (Builder $innerQuery) use ($category) {
                return $innerQuery->where('code', $category->code);
            });
        $query = $productController->filter($query, $search);
        // Filter out shops that already have the product
        return view('category.add-products-form', [
            'title' => "{$this->title} {$category->code} : Add Products",
            'search' => $search,
            'category' => $category,
            'products' => $query->paginate(5),
        ]);
    }
    //Redirect to shops.add-products-form
    function addProduct(ServerRequestInterface $request, string $cateCode): RedirectResponse
    {
        $cate = $this->find($cateCode);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $product = Product::whereDoesntHave('category', function (Builder $innerQuery)
        use ($cate) {
            return $innerQuery->where('code', $cate->code);
        })->where('code', $data['category'])->firstOrFail();
        //attach() cannot use with HasMany() of product() in category model
        // Associate the product with the category
        // Assuming your Product model has a `category_id` field
        $product->category_id = $cate->id; // Set the category_id
        $product->save(); // Save the changes
        return redirect()->back()->with('message', "{$product->code} has been added to {$cate->code}");
    }
     //search part
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
}
