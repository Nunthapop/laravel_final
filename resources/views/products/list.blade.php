@extends('layouts.main')
@section('title', 'Product')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <form action="{{ route('products.list') }}" method="get" class="search-form">
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
        <br />
        <button type="submit" class="primary">Search</button>
        <a href="{{ route('products.list') }}">
            <button type="button" class="accent">Clear</button>
        </a>
    </form>
    <div>{{ $products->withQueryString()->links() }}</div>

    <body>
        @php
            session( )->put('bookmark.products.view',url()->full());
        @endphp
        <table class="lg:w-1/2">
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Shops count</th>
            </tr>
            <tbody>
                <tr>
                    @foreach ($products as $product)
                        <td class="underline font-bold hover:text-blue-600"> <a
                                href="{{ route('products.view', ['product' => $product->code]) }}"> {{ $product->code }}
                            </a> </td>
                        <td> {{ $product->name }}</td>
                        <td> {{ $product->price }}</td>
                       <td>{{ $product->Category->name }}</td>
                        <td> {{ $product->shops_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    <nav>
        <ul>
        @can('create', \App\Models\Product::class)
        <li>
        <a href="{{ route('products.create-form') }}">New Product</a>
        </li>
        @endcan
        </ul>
        </nav>
    </html>
@endsection
