<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\View\View;
class ShopController extends Controller
{
    private string $title = 'Shop';


//list
    function list(): View
    {
       
      $names = Shop::orderby('code')->get(); //Shop Models
        return view('shops.list', [
            'title' => "{$this->title} : List",
            'shops' => Shop::orderBy('code')->get(),
        ]);
    }
    //view
    function show(string $ShopName): View
    {
        $name = Shop::where('code',$ShopName)->firstOrFail();
        return view('shops.view', [
            'title' => "{$this->title} : list",
            'shop' => $name,
        ]);
    }
}

