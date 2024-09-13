@extends('layouts.main')
@section('title',$title)

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    {{-- </head> --}}
    <form action="{{ route('shops.view-products' , ['shop' => $shops->code]) }}" method="get" class="search-form">
        <label>
            Search
            <input type="text" name="term" value="{{ $search['term'] }}" />
        </label>
        <label>
            Min Price
            <input type="number" name="minPrice" value="{{ $search['minPrice'] }}" step="any" />
        </label><br />
        <label>
            Max Price
            <input type="number" name="maxPrice" value="{{ $search['maxPrice'] }}" step="any" />
        </label><br />
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('shops.view-products' , ['shop' => $shops->code]) }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $products->withQueryString()->links() }}</div>
    
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Owner</th>
             
            </tr>
            <tbody>
                <tr>
                    @foreach ($products as $product)
                        <td class="underline font-bold hover:text-blue-600"> <a
                                href="{{ route('products.view', ['product' => $product->code]) }}"> {{ $product->code }}
                            </a> </td>
                        <td> {{ $product->name }}</td>
                        <td> {{ $product->price }}</td>
                      
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('shops.create-form') }}">Create shops</a>
   

    </html>
@endsection
