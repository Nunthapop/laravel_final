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
            'shop' => $query->paginate(5),
           
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
}
