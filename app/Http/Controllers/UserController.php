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
use Illuminate\Database\Eloquent\Model;

class UserController extends SearchableController
{
    //user dont have 'code' column so use findByEmail instead for viewing user
    function findByEmail(string $code): Model
    {
        return $this->getQuery()->where('email', $code)->firstOrFail();
    }
    private string $title = 'User';
    public function getQuery(): Builder
    {
        //return ข้อมูลจาก database เรียงตาม code
        // Return the query builder for the Product model
        return User::orderby('email');
    }

    function filterByTerm(Builder|Relation $query, ?string $term): Builder|Relation
    {


        if (!empty($term)) {
            foreach (\preg_split('/\s+/', \trim($term)) as $word) {
                $query->where(function (Builder $innerQuery) use ($word) {
                    $innerQuery
                        ->where('email', 'LIKE', "%{$word}%")
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

    function show(string $email): View
    {
        $user = $this->findByEmail($email);
        return view('user.view', [
            'title' => "{$this->title} : View",
            'users' => $user,
        ]);
    }
    function showCreateForm(): View
    {
        $user = User::all();
        return view('user.create-form', [
            'title' => "{$this->title} : Create ",
            'user' => $user,
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

    function showUpdateForm(string $email): View
    {
        
        // Gate::authorize('update', Product::class);
        $user = $this->findByEmail($email);
        $user_role = User::all();
        // $categories = 
        return view('user.update-form', [
            'title' => "{$this->title} : Update",
            'users' => $user,
            'user_role' => $user_role
        ]);
    }
    function update(ServerRequestInterface $request, string $email): RedirectResponse
    {
        // Gate::authorize('update', Product::class);
        $user = $this->findByEmail($email);
        $data = $request->getParsedBody();
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }else {
            // Optionally, you can leave the password unchanged
            // or handle the case where password should remain the same
            unset($data['password']); // Remove password from the data array if it's not set
        }
        $user->fill($data);
        $user->save();
        return redirect()->route('user.view', ['userEmail' => $user->email])->with('message',  $user->email . 'has been updated');
    }

}
