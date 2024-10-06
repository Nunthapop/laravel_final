<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;

class UserController extends SearchableController
{
    private string $title = 'Category';
    public function getQuery(): Builder
    {
        //return ข้อมูลจาก database เรียงตาม code
        // Return the query builder for the Product model
        return User::orderby('name');
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
    function prepareSearch(array $search): array
    {
        $search = parent::prepareSearch($search);
        $search = \array_merge([
            'minPrice' => null,
            'maxPrice' => null,
        ], $search);
        return $search;
    }
    //list 
    function list(ServerRequestInterface $request): View
    {
        $search = $this->prepareSearch($request->getQueryParams());
        $query = $this->search($search);
        //category Models
        return view('user.list', [
            'title' => "{$this->title} : List",
            'search' => $search,
            'users' => $query->paginate(5),

        ]);
    }
    function showCreateForm(): View
    {
        $user =User::all();
        return view('user.create-form', [
            'title' => "{$this->title} : Create ",
            'users' => $user,
        ]);
    }
    function create(ServerRequestInterface $request): RedirectResponse
    {
        // Gate::authorize('create', Product::class);
        $data = $request->getParsedBody();
        // dd($data);
    // Ensure the 'category_id' field is included in the parsed body
        $user = User::create([
        'email' => $data['email'],
        'name' => $data['name'],
        'password' => $data['password'],
        'role' => $data['role'],
         // Make sure this is passed
    ]);
        return redirect()->route('user.list');
    }
}
