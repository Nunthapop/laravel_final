<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Category;
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
    function list(ServerRequestInterface $request): View{
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
    function show(string $cateCode): View{
        $Cates = $this->find($cateCode);
        return view('category.view', [
            'title' => "{$this->title} : View",
            'Cates' => $Cates,
        ]);
    }
    //create 
    function showCreateForm() :View{
       return view( 'category.create-form' , [
        'title' => "{$this->title} :Create"
       ]);
    }
    function create(ServerRequestInterface $request): RedirectResponse{
        $category = Category::create($request->getParsedBody());
        return redirect()->route('category.list');
    }
    //update
    function showUpdateForm(string $cateCode):View{
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
        return redirect()->route('category.view', ['cateCode' => $category->code]);
    }
    //delete
    function delete(string $cateCode): RedirectResponse
    {
        $category = $this->find($cateCode);
        $category->delete();
        return redirect()->route('category.list');
    }
}
