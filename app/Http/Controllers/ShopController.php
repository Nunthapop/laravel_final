<?php

namespace App\Http\Controllers;


use App\Models\Shop;
use Illuminate\View\View;
use App\Models\shops;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;

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
        $query = $this->search($search);
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
        $name = Shop::where('code',$ShopName)->firstOrFail();
        return view('shops.view', [
            'title' => "{$this->title} : list",
            'shop' => $name,
        ]);
    }
    //create
    function showCreateForm():View
{
    return view('shops.create-form', [
        'title' => "{$this->title} : Create ",
    ]);
}
    function create(ServerRequestInterface $request): RedirectResponse{
        $shops = Shop::create($request->getParsedBody());
        return redirect()->route('shops.list');
    }

    //update
    function showUpdateForm(string $shopsCode):View{
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

}   


